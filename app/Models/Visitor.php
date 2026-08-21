<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'last_visit_at',
        'visits_count',
        'visit_date',
    ];
    
    protected $casts = [
        'last_visit_at' => 'datetime',
        'visit_date' => 'date',
    ];
}
