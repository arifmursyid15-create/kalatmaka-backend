<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'message', 'rating', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
