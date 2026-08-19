<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'reference',
        'payment_method',
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
            }
        });

        static::updated(function (Deposit $deposit) {
            if ($deposit->isDirty('status') && $deposit->status === 'completed') {
                $deposit->user->increment('wallet_balance', $deposit->amount);
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
}
