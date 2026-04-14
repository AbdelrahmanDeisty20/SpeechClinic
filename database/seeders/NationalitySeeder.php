<?php

namespace Database\Seeders;

use App\Models\Nationality;
use Illuminate\Database\Seeder;

class NationalitySeeder extends Seeder
{
    public function run(): void
    {
        $nationalities = [
            ['name_ar' => 'مصري',     'name_en' => 'Egyptian'],
            ['name_ar' => 'سعودي',    'name_en' => 'Saudi'],
            ['name_ar' => 'كويتي',    'name_en' => 'Kuwaiti'],
            ['name_ar' => 'إماراتي',  'name_en' => 'Emirati'],
            ['name_ar' => 'أردني',    'name_en' => 'Jordanian'],
            ['name_ar' => 'بحريني',   'name_en' => 'Bahraini'],
            ['name_ar' => 'قطري',     'name_en' => 'Qatari'],
            ['name_ar' => 'عُماني',   'name_en' => 'Omani'],
            ['name_ar' => 'لبناني',   'name_en' => 'Lebanese'],
            ['name_ar' => 'سوري',     'name_en' => 'Syrian'],
            ['name_ar' => 'عراقي',    'name_en' => 'Iraqi'],
            ['name_ar' => 'فلسطيني',  'name_en' => 'Palestinian'],
            ['name_ar' => 'يمني',     'name_en' => 'Yemeni'],
            ['name_ar' => 'سوداني',   'name_en' => 'Sudanese'],
            ['name_ar' => 'ليبي',     'name_en' => 'Libyan'],
            ['name_ar' => 'تونسي',    'name_en' => 'Tunisian'],
            ['name_ar' => 'جزائري',   'name_en' => 'Algerian'],
            ['name_ar' => 'مغربي',    'name_en' => 'Moroccan'],
        ];

        foreach ($nationalities as $nationality) {
            Nationality::updateOrCreate(
                ['name_en' => $nationality['name_en']],
                $nationality
            );
        }
    }
}
