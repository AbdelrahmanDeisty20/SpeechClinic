<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'image',
    ];

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->{'title_' . $locale} ?? $this->title_ar;
    }

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $this->{'description_' . $locale} ?? $this->description_ar;
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) return null;

        // Ensure we don't double up on the 'banners/' prefix if it's already in the database
        $path = str_contains($this->image, '/') ? $this->image : 'banners/' . $this->image;

        return asset('storage/' . $path);
    }
}
