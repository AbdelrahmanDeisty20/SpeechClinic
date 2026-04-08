<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'cv',
        'image',
    ];

    public function getImageAttribute($value)
    {
        return asset('storage/cvs/' . $value);
    }

    public function getCvAttribute($value)
    {
        return asset('storage/' . $value);
    }
}
