<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'photo_limit',
        'video_limit',
        'features',
        'pricing',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'pricing' => 'array',
        ];
    }
}
