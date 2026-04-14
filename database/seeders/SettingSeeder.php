<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name_ar',     'value' => 'عيادة النطق',                  'type' => 'text'],
            ['key' => 'site_name_en',     'value' => 'Speech Clinic',                'type' => 'text'],
            ['key' => 'contact_email',    'value' => 'info@speechclinic.com',         'type' => 'text'],
            ['key' => 'contact_phone',    'value' => '+20 100 000 0000',              'type' => 'text'],
            ['key' => 'whatsapp',         'value' => '+20 100 000 0001',              'type' => 'text'],
            ['key' => 'address_ar',       'value' => 'القاهرة، مصر',                 'type' => 'text'],
            ['key' => 'address_en',       'value' => 'Cairo, Egypt',                  'type' => 'text'],
            ['key' => 'facebook_url',     'value' => 'https://facebook.com/speechclinic',  'type' => 'text'],
            ['key' => 'instagram_url',    'value' => 'https://instagram.com/speechclinic', 'type' => 'text'],
            ['key' => 'about_ar',         'value' => 'عيادة متخصصة في علاج النطق واللغة', 'type' => 'text'],
            ['key' => 'about_en',         'value' => 'A clinic specialized in speech and language therapy', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
