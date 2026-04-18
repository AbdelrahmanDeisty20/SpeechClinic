<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aِppointment extends Model
{
    protected $fillable = [
        'user_id',
        'day_id',
        'time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
