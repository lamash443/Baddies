<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatArchive extends Model
{
    protected $fillable = ['user_id', 'archived_user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function archivedUser()
    {
        return $this->belongsTo(User::class, 'archived_user_id');
    }
}
