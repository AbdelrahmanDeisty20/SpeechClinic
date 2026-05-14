<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableTime extends Model
{
    protected $fillable = [
        'time',
        'limit',
        'type',
        'day_id',
        'date_id',
    ];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function date()
    {
        return $this->belongsTo(AvailableDate::class, 'date_id');
    }
}