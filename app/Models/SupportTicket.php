<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SupportTicket extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['subject', 'status'])
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

    /**
     * Check if 'reference' column physically exists in support_tickets table,
     * and auto-creates it on the fly if missing on the production server.
     */
    public static function hasReferenceColumn(): bool
    {
        static $hasCol = null;
        if ($hasCol !== null) {
            return $hasCol;
        }

        try {
            if (Schema::hasTable('support_tickets')) {
                if (!Schema::hasColumn('support_tickets', 'reference')) {
                    Schema::table('support_tickets', function ($table) {
                        $table->string('reference', 20)->nullable()->index()->after('id');
                    });
                }
                return $hasCol = true;
            }
        } catch (\Throwable $e) {
            Log::warning('[SupportTicket] Reference column check/create notice: ' . $e->getMessage());
        }

        return $hasCol = false;
    }

    protected static function booted(): void
    {
        static::creating(function (SupportTicket $ticket) {
            if (static::hasReferenceColumn()) {
                if (empty($ticket->attributes['reference'])) {
                    $ticket->attributes['reference'] = static::generateReference();
                }
            } else {
                unset($ticket->attributes['reference']);
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
            // Shuffle characters after KB-
            $parts = str_split(substr($code, 3));
            shuffle($parts);
            $finalRef = 'KB-' . implode('', $parts);

            $exists = false;
            if (static::hasReferenceColumn()) {
                try {
                    $exists = static::where('reference', $finalRef)->exists();
                } catch (\Throwable $e) {
                    $exists = false;
                }
            }
        } while ($exists);

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
        $id = $this->id ?? 1;
        $hash = strtoupper(substr(md5('kb-ticket-' . $id), 0, 6));
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
