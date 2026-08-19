<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationSubmission extends Model
{
    protected $fillable = ['user_id', 'photo_path', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
