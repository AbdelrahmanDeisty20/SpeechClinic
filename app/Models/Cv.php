<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'image',
    ];

    public function getImageUrlAttribute()
    {
        return asset('storage/cvs/' . $this->image);
    }
    public function getNameAttribute($value)
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }
    public function getTitleAttribute($value)
    {
        return app()->getLocale() == 'ar' ? $this->title_ar : $this->title_en;
    }
    public function getDescriptionAttribute($value)
    {
        return app()->getLocale() == 'ar' ? $this->description_ar : $this->description_en;
    }
}
