<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReferralController extends Controller
{
    /**
     * Redeem the authenticated user's referral bonus balance
     * by transferring it into their main wallet balance.
     */
    public function redeem(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $balance = (float) $user->referral_balance;

        if ($balance <= 0) {
            return redirect()->route('profile.edit', [], 302)
                ->withFragment('tab-referrals')
                ->withErrors(['referral' => 'You have no referral bonus available to redeem.']);
        }

        DB::transaction(function () use ($user, $balance) {
            // Mark referral earnings as redeemed
            $user->referralEarnings()
                ->where('status', 'awarded')
                ->update(['status' => 'redeemed']);

            // Create an audit deposit record with payment_method = referral_bonus
            $reference = 'REF_REDEEM_' . time() . '_' . Str::lower(Str::random(4));
            Deposit::create([
                'user_id'        => $user->id,
                'amount'         => $balance,
                'status'         => 'completed',
                'reference'      => $reference,
                'payment_method' => 'referral_bonus',
                'meta'           => [
                    'purpose' => 'referral_redemption',
                    'note'    => 'Referral bonus redeemed to wallet',
                ],
            ]);
            // Note: Deposit observer increments wallet_balance automatically on 'completed' status
            // So we only need to reset referral_balance
            $user->update(['referral_balance' => 0]);
        });

        Log::info("Referral redemption: user #{$user->id} redeemed KSh {$balance} to wallet.");

        return redirect(route('profile.edit') . '#tab-referrals')
            ->with('success', 'KSh ' . number_format($balance, 2) . ' referral bonus has been added to your wallet.');
    }
}
