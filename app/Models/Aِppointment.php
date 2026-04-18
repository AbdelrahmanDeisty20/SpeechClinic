<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aِppointment extends Model
{
    protected $fillable = [
        'user_id',
        'day_id',
        'bookin_monthly_id',
        'specialist_id',
        'time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function bookinMonthly()
    {
        return $this->belongsTo(BookinMonthly::class, 'bookin_monthly_id');
    }
}
