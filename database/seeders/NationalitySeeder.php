<?php

namespace Database\Seeders;

use App\Models\Nationality;
use Illuminate\Database\Seeder;

class NationalitySeeder extends Seeder
{
    public function run(): void
    {
        Nationality::truncate();

        Nationality::insert([
            ['name_ar' => 'مصري',     'name_en' => 'Egyptian',    'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'سعودي',    'name_en' => 'Saudi',       'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'كويتي',    'name_en' => 'Kuwaiti',     'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'إماراتي',  'name_en' => 'Emirati',     'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'أردني',    'name_en' => 'Jordanian',   'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'بحريني',   'name_en' => 'Bahraini',    'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'قطري',     'name_en' => 'Qatari',      'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'عُماني',   'name_en' => 'Omani',       'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'لبناني',   'name_en' => 'Lebanese',    'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'سوري',     'name_en' => 'Syrian',      'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'عراقي',    'name_en' => 'Iraqi',       'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'فلسطيني',  'name_en' => 'Palestinian', 'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'يمني',     'name_en' => 'Yemeni',      'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'سوداني',   'name_en' => 'Sudanese',    'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'ليبي',     'name_en' => 'Libyan',      'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'تونسي',    'name_en' => 'Tunisian',    'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'جزائري',   'name_en' => 'Algerian',    'created_at' => now(), 'updated_at' => now()],
            ['name_ar' => 'مغربي',    'name_en' => 'Moroccan',    'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
