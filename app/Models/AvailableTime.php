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
    ];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}