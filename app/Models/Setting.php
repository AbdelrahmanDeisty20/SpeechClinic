<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key_ar',
        'key_en',
        'value_ar',
        'value_en',
        'type',
    ];

    // NOTE: لا تستخدم getKeyAttribute() هنا لأن 'key' محجوزة في Eloquent
    // الـ localization يتم في SettingResource مباشرة
}
