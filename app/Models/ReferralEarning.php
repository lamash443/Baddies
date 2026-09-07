<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referee_id',
        'deposit_id',
        'deposit_amount',
        'bonus_amount',
        'commission_rate',
        'status',
    ];

    protected $casts = [
        'deposit_amount'  => 'decimal:2',
        'bonus_amount'    => 'decimal:2',
        'commission_rate' => 'decimal:2',
    ];

    /** The referrer (the user who invited) */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /** The referee (the invited user who made a deposit) */
    public function referee()
    {
        return $this->belongsTo(User::class, 'referee_id');
    }

    /** The deposit that triggered this earning */
    public function deposit()
    {
        return $this->belongsTo(Deposit::class);
    }
}
