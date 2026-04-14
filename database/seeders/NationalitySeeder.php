<?php

namespace Database\Seeders;

use App\Models\Nationality;
use Illuminate\Database\Seeder;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nationalities = [
            ['name_ar' => 'مصري', 'name_en' => 'Egyptian'],
            ['name_ar' => 'سعودي', 'name_en' => 'Saudi'],
            ['name_ar' => 'كويتي', 'name_en' => 'Kuwaiti'],
            ['name_ar' => 'إماراتي', 'name_en' => 'Emirati'],
            ['name_ar' => 'أردني', 'name_en' => 'Jordanian'],
        ];

        foreach ($nationalities as $nationality) {
            Nationality::updateOrCreate(['name_en' => $nationality['name_en']], $nationality);
        }
    }
}
