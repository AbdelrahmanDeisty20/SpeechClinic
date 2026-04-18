<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookinMonthly extends Model
{
    protected $fillable = [
        'booking_id',
        'image',
        'price',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'bookin_monthly_id');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) return null;
        return asset('storage/monthlies/' . $this->image);
    }
}

