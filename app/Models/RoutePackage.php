<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutePackage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'items'     => 'array',
        'is_active' => 'boolean',
    ];
}
