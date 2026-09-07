<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserVideo extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'path', 'title', 'views'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
