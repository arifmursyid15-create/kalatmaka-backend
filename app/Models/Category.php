<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'type'];

    public function katalogs()
    {
        return $this->hasMany(Katalog::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
