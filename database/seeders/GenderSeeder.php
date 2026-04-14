<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    public function run(): void
    {
        $genders = [
            ['name_ar' => 'ذكر',  'name_en' => 'Male'],
            ['name_ar' => 'أنثى', 'name_en' => 'Female'],
        ];

        foreach ($genders as $gender) {
            Gender::updateOrCreate(
                ['name_en' => $gender['name_en']],
                $gender
            );
        }
    }
}
