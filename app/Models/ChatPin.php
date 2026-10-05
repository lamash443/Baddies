<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatPin extends Model
{
    protected $fillable = ['user_id', 'pinned_user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pinnedUser()
    {
        return $this->belongsTo(User::class, 'pinned_user_id');
    }
}
