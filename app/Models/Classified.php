<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classified extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'city',
        'image_path',
        'description',
        'phone',
        'contact_name',
        'payment_status',
        'status',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
