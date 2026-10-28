<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SupportTicket extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['subject', 'status', 'reference'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $fillable = [
        'user_id',
        'reference',
        'name',
        'email',
        'subject',
        'message',
        'status',
    ];

    protected static function booted(): void
    {
        static::creating(function (SupportTicket $ticket) {
            if (empty($ticket->reference)) {
                $ticket->reference = static::generateReference();
            }
        });
    }

    /**
     * Generate a unique ticket reference with random digits and uppercase letters.
     * Example: KB-8F3K9M
     */
    public static function generateReference(): string
    {
        $digits  = '23456789';
        $letters = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $all     = $digits . $letters;

        do {
            // Guarantee a mix of random digits and letters
            $code = 'KB-';
            $code .= $digits[random_int(0, strlen($digits) - 1)];
            $code .= $letters[random_int(0, strlen($letters) - 1)];
            for ($i = 0; $i < 4; $i++) {
                $code .= $all[random_int(0, strlen($all) - 1)];
            }
            // Shuffle the 6 characters after KB- so order is unpredictable
            $parts = str_split(substr($code, 3));
            shuffle($parts);
            $finalRef = 'KB-' . implode('', $parts);
        } while (static::where('reference', $finalRef)->exists());

        return $finalRef;
    }

    /**
     * Accessor for reference: if not set in DB, returns a deterministic fallback with letters + digits.
     */
    public function getReferenceAttribute(?string $value): string
    {
        if (!empty($value)) {
            return $value;
        }

        // Deterministic fallback for records created before the reference column
        $hash = strtoupper(substr(md5('kb-ticket-' . $this->id), 0, 6));
        return 'KB-' . $hash;
    }

    /**
     * Explicit reference code accessor
     */
    public function getReferenceCodeAttribute(): string
    {
        return $this->reference;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
