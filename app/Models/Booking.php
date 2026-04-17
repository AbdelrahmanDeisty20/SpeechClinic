<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'available_time_id',
        'booking_number',
        'child_name',
        'child_age',
        'child_photo',
        'problem_description',
        'type',
        'price',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availableTime()
    {
        return $this->belongsTo(AvailableTime::class);
    }

    public function getChildPhotoUrlAttribute()
    {
        if (!$this->child_photo) return null;
        return asset('storage/children/' . $this->child_photo);
    }
}
