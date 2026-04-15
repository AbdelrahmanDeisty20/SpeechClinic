<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'name',
        'comment',
        'is_active',
        'user_id',
        'rate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
