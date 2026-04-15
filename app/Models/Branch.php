<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'phone',
        'lat',
        'lng',
        'address_link',
    ];

    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }

    public function callUs()
    {
        return $this->hasMany(callUs::class);
    }

    public function days()
    {
        return $this->hasMany(Day::class);
    }
}

