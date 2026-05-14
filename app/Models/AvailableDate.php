<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableDate extends Model
{
    protected $fillable = [
        'date',
        'day_id',
    ];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function availableTimes()
    {
        return $this->hasMany(AvailableTime::class, 'date_id');
    }
}
