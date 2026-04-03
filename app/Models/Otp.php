<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'phone',
        'email',
        'otp',
        'expires_at',
        'type',
        'user_id',
        'verified_at',
        'reset_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
