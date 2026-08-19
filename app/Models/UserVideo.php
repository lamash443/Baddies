<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVideo extends Model
{
    protected $fillable = ['user_id', 'path', 'title', 'views'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
