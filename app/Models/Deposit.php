<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'reference',
        'payment_method',
        'checkout_request_id',
        'payhero_reference',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user()
    {

        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function (Deposit $deposit) {
            if ($deposit->status === 'completed') {
                $deposit->user->increment('wallet_balance', $deposit->amount);
                static::processReferralBonus($deposit);
            }
        });

        static::updated(function (Deposit $deposit) {
            if ($deposit->isDirty('status') && $deposit->status === 'completed') {
                $deposit->user->increment('wallet_balance', $deposit->amount);
                static::processReferralBonus($deposit);
            }
            if ($deposit->isDirty('status') && $deposit->getOriginal('status') === 'completed' && $deposit->status !== 'completed') {
                $deposit->user->decrement('wallet_balance', $deposit->amount);
            }
        });

        static::deleted(function (Deposit $deposit) {
            if ($deposit->status === 'completed') {
                $deposit->user->decrement('wallet_balance', $deposit->amount);
            }
        });
    }

    /**
     * Automatically award referral bonuses for wallet top-ups.
     */
    protected static function processReferralBonus(Deposit $deposit)
    {
        $user = $deposit->user;
        $meta = $deposit->meta ?? [];
        $purpose = $meta['purpose'] ?? 'wallet';

        // Only award bonus for real wallet top-ups, not for referral redemptions or plan purchases
        if ($purpose === 'wallet' && $user->referred_by_id) {
            // Check if we already processed a bonus for this deposit to prevent double-awarding
            $alreadyAwarded = ReferralEarning::where('deposit_id', $deposit->id)->exists();
            
            if (!$alreadyAwarded) {
                $referrer = User::find($user->referred_by_id);
                if ($referrer) {
                    // Read commission rate from site settings (fallback to 10%)
                    $setting = \App\Models\Setting::getSettings();
                    $commissionRate = (float) ($setting->referral_commission_rate ?? 10.00);
                    $bonus = round($deposit->amount * ($commissionRate / 100), 2);

                    if ($bonus > 0) {
                        DB::transaction(function () use ($referrer, $user, $deposit, $bonus, $commissionRate) {
                            ReferralEarning::create([
                                'referrer_id'     => $referrer->id,
                                'referee_id'      => $user->id,
                                'deposit_id'      => $deposit->id,
                                'deposit_amount'  => $deposit->amount,
                                'bonus_amount'    => $bonus,
                                'commission_rate' => $commissionRate,
                                'status'          => 'awarded',
                            ]);

                            $referrer->increment('referral_balance', $bonus);
                            $referrer->increment('total_referral_earnings', $bonus);
                        });

                        Log::info("Referral bonus: KSh {$bonus} awarded to referrer #{$referrer->id} for deposit #{$deposit->id} by user #{$user->id}");
                    }
                }
            }
        }
    }
}
