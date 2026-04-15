<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableTime extends Model
{
    protected $fillable = [
        'start_time',
        'end_time',
        'day_id',
    ];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}