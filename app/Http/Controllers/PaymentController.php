<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\User;
use App\Models\Classified;
use App\Models\MembershipPlan;
use App\Services\PayHeroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected PayHeroService $payHeroService;

    public function __construct(PayHeroService $payHeroService)
    {
        $this->payHeroService = $payHeroService;
    }

    /**
     * Initiate PayHero Payment (M-Pesa STK Push)
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'purpose' => 'required|string|in:wallet,membership,classified',
            'amount' => 'required_if:purpose,wallet|nullable|numeric|min:50',
            'plan_type' => 'required_if:purpose,membership|nullable|string',
            'plan_days' => 'required_if:purpose,membership|nullable|integer',
            'classified_id' => 'required_if:purpose,classified|nullable|integer',
        ]);

        $purpose = $request->purpose;
        $amount = 0.00;

        if ($purpose === 'wallet') {
            $amount = (float) $request->amount;
        } elseif ($purpose === 'classified') {
            $amount = 1000.00;
            // Verify classified ad exists
            $classified = Classified::find($request->classified_id);
            if (!$classified) {
                return response()->json(['success' => false, 'message' => 'Classified ad not found.'], 404);
            }
        } elseif ($purpose === 'membership') {
            $plan = MembershipPlan::where('slug', $request->plan_type)->first();
            if (!$plan) {
                return response()->json(['success' => false, 'message' => 'Membership plan not found.'], 404);
            }

            $pricing = $plan->pricing;
            $days = (int) $request->plan_days;
            if (!isset($pricing[$days])) {
                return response()->json(['success' => false, 'message' => 'Invalid plan duration select.'], 422);
            }

            $amount = (float) $pricing[$days];
        }

        if ($amount <= 0) {
            return response()->json(['success' => false, 'message' => 'Invalid payment amount calculated.'], 422);
        }

        // Create unique reference for matching webhook
        $reference = 'DEP_' . time() . '_' . Str::lower(Str::random(6));

        // Create pending deposit
        $deposit = Deposit::create([
            'user_id' => auth()->id(),
            'amount' => $amount,
            'status' => 'pending',
            'reference' => $reference,
            'payment_method' => 'mpesa',
            'meta' => [
                'purpose' => $purpose,
                'plan_type' => $request->plan_type ?? null,
                'plan_days' => $request->plan_days ? (int) $request->plan_days : null,
                'classified_id' => $request->classified_id ? (int) $request->classified_id : null,
            ]
        ]);

        // Initiate via PayHero
        $result = $this->payHeroService->initiatePayment($amount, $request->phone, $reference);

        if ($result['success']) {
            $checkoutRequestId = $result['data']['CheckoutRequestID'] ?? $result['data']['checkout_request_id'] ?? null;
            $payheroRef = $result['data']['reference'] ?? null;

            $deposit->update([
                'checkout_request_id' => $checkoutRequestId,
                'payhero_reference' => $payheroRef,
            ]);

            return response()->json([
                'success' => true,
                'reference' => $reference,
                'message' => 'STK Push sent to ' . $request->phone . '. Please check your phone for the PIN prompt.'
            ]);
        }

        // Mark failed if API request failed
        $deposit->update(['status' => 'failed']);

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Could not initiate M-Pesa payment.'
        ], 500);
    }

    /**
     * PayHero Webhook Callback
     */
    public function webhook(Request $request)
    {
        Log::info('PayHero Webhook Received:', $request->all());

        // PayHero wraps the result inside a 'response' key.
        // Try nested first, then fall back to flat payload for forward-compatibility.
        $nested      = $request->input('response');
        $externalRef = $nested['ExternalReference']
            ?? $nested['external_reference']
            ?? $request->input('ExternalReference')
            ?? $request->input('external_reference');

        // Determine success/status from nested or flat fields
        $rawStatus  = $nested['Status'] ?? $request->input('status', '');
        $resultCode = $nested['ResultCode'] ?? $request->input('ResultCode');
        $success    = $request->input('success');             // top-level boolean
        $status     = Str::lower((string) $rawStatus);
        $payheroRef = $nested['MerchantRequestID'] ?? $request->input('reference');
        $networkMsg = $nested['ResultDesc'] ?? $request->input('network_message') ?? $request->input('NetworkMessage');

        if (!$externalRef) {
            Log::warning('PayHero Webhook: external_reference is missing.', $request->all());
            return response()->json(['success' => false, 'message' => 'external_reference missing'], 400);
        }

        // Find pending deposit
        $deposit = Deposit::where('reference', $externalRef)->first();

        if (!$deposit) {
            Log::warning('PayHero Webhook: Deposit not found for reference: ' . $externalRef);
            return response()->json(['success' => false, 'message' => 'Deposit not found'], 404);
        }

        // Check if already completed
        if ($deposit->status === 'completed') {
            Log::info('PayHero Webhook: Deposit already completed: ' . $externalRef);
            return response()->json(['success' => true, 'message' => 'Already processed']);
        }

        // Determine if payment is successful.
        // ResultCode 0 = success on M-Pesa; status field may be 'Success'/'QUEUED'/'Failed'.
        $isSuccessful = ($success === true || $success === 'true'
            || $status === 'success'
            || (isset($resultCode) && (int) $resultCode === 0));

        if ($isSuccessful) {
            $this->processSuccessfulDeposit($deposit, $payheroRef ?? null);

            return response()->json(['success' => true, 'message' => 'Payment processed successfully']);
        } else {
            // Payment failed or cancelled by user
            $deposit->update([
                'status' => 'failed',
                'meta' => array_merge($deposit->meta ?? [], [
                    'failure_reason' => $networkMsg,
                ]),
            ]);

            Log::info('PayHero Webhook: Deposit marked failed: ' . $externalRef . ' Reason: ' . ($networkMsg ?? 'unknown'));

            return response()->json(['success' => true, 'message' => 'Payment failed status recorded']);
        }
    }

    /**
     * Poll Payment Status
     * When the deposit is still pending we also query PayHero's API directly
     * so that cancellations / failures are surfaced on the next poll cycle
     * without having to wait for the webhook to arrive.
     */
    public function status(string $reference)
    {
        $deposit = Deposit::where('reference', $reference)->firstOrFail();

        // Use payhero_reference (the UUID) — that's what PayHero's status API expects in v2.
        if ($deposit->status === 'pending') {
            $ref = $deposit->payhero_reference ?? $deposit->checkout_request_id;
            $live = $ref
                ? $this->payHeroService->checkStatus($ref)
                : ['status' => 'QUEUED', 'network_message' => null];

            if ($live['status'] === 'SUCCESS') {
                // Shouldn't normally happen (webhook should have fired), but handle it
                $this->processSuccessfulDeposit($deposit);

            } elseif ($live['status'] === 'FAILED') {
                $networkMessage = $live['network_message'];
                $deposit->update([
                    'status' => 'failed',
                    'meta'   => array_merge($deposit->meta ?? [], [
                        'failure_reason' => $networkMessage,
                    ]),
                ]);
            }
            // If QUEUED, leave as pending — keep polling
            $deposit->refresh();
        }

        $failureReason = $deposit->meta['failure_reason'] ?? null;
        $isCancelled   = $failureReason && str_contains(strtolower($failureReason), 'cancel');

        return response()->json([
            'status'         => $deposit->status,
            'amount'         => $deposit->amount,
            'purpose'        => $deposit->meta['purpose'] ?? 'wallet',
            'failure_reason' => $failureReason,
            'is_cancelled'   => $isCancelled,
        ]);
    }

    protected function processSuccessfulDeposit(Deposit $deposit, ?string $payheroRef = null)
    {
        // Check if already completed
        if ($deposit->status === 'completed') {
            return;
        }

        // Update deposit status to completed
        // (Note: Deposit model observer will increment user's wallet_balance automatically)
        $deposit->update([
            'status' => 'completed',
            'payhero_reference' => $payheroRef ?? $deposit->payhero_reference,
        ]);

        // Retrieve associated user
        $user = $deposit->user;
        $meta = $deposit->meta;

        $purpose = $meta['purpose'] ?? 'wallet';

        if ($purpose === 'membership') {
            $planType = $meta['plan_type'] ?? null;
            $planDays = $meta['plan_days'] ?? null;

            if ($planType && $planDays) {
                $plan = MembershipPlan::where('slug', $planType)->first();
                if ($plan) {
                    // Deduct from wallet balance that was just incremented
                    $user->decrement('wallet_balance', $deposit->amount);

                    if ($planType === 'chat') {
                        $user->update([
                            'chat_plan' => 'active',
                            'chat_expires_at' => now()->addDays($planDays),
                        ]);
                        Log::info("PayHero Deposit: Chat subscription activated for user {$user->id}");
                    } else {
                        $updateData = [
                            'subscription_plan' => $planType,
                            'subscription_expires_at' => now()->addDays($planDays),
                            'photo_limit' => $plan->photo_limit,
                            'video_limit' => $plan->video_limit,
                        ];
                        $user->update($updateData);
                        Log::info("PayHero Deposit: Membership {$planType} activated for user {$user->id}");
                    }
                }
            }
        } elseif ($purpose === 'classified') {
            $classifiedId = $meta['classified_id'] ?? null;
            if ($classifiedId) {
                $classified = Classified::find($classifiedId);
                if ($classified) {
                    // Deduct from wallet balance that was just incremented
                    $user->decrement('wallet_balance', $deposit->amount);

                    $classified->update([
                        'payment_status' => 'paid',
                        'status' => 'approved',
                    ]);
                    Log::info("PayHero Deposit: Classified ad {$classifiedId} marked as paid.");
                }
            }
        }
    }
}
