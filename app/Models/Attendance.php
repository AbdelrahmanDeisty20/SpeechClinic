<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'date',
        'check_in',
        'check_out',
        'lat',
        'lng',
        'status',
    ];

    /**
     * Relationship with the specialist (user).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with the branch.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
