<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    public function run(): void
    {
        Gender::truncate();

        Gender::insert([
            ['name_ar' => 'ذكر',  'name_en' => 'Male',   'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'أنثى', 'name_en' => 'Female', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
