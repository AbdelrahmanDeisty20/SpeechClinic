<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class callUs extends Model
{
    protected $fillable = [
        'phone',
        'branch_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
