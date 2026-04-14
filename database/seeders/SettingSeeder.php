<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name_ar', 'value' => 'عيادة النطق', 'type' => 'text'],
            ['key' => 'site_name_en', 'value' => 'Speech Clinic', 'type' => 'text'],
            ['key' => 'contact_email', 'value' => 'info@speechclinic.com', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '+123456789', 'type' => 'text'],
            ['key' => 'address_ar', 'value' => 'العنوان هنا', 'type' => 'text'],
            ['key' => 'address_en', 'value' => 'Address here', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // Also create some random settings
        Setting::factory(3)->create();
    }
}
