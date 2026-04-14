<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::truncate();

        Setting::insert([
            [
                'key_ar'     => 'اسم الموقع',
                'key_en'     => 'site_name',
                'value_ar'   => 'عيادة النطق',
                'value_en'   => 'Speech Clinic',
                'type'       => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_ar'     => 'البريد الإلكتروني',
                'key_en'     => 'contact_email',
                'value_ar'   => 'info@speechclinic.com',
                'value_en'   => 'info@speechclinic.com',
                'type'       => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_ar'     => 'رقم الهاتف',
                'key_en'     => 'contact_phone',
                'value_ar'   => '+20 100 000 0000',
                'value_en'   => '+20 100 000 0000',
                'type'       => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_ar'     => 'واتساب',
                'key_en'     => 'whatsapp',
                'value_ar'   => '+20 100 000 0001',
                'value_en'   => '+20 100 000 0001',
                'type'       => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_ar'     => 'العنوان',
                'key_en'     => 'address',
                'value_ar'   => 'القاهرة، مصر',
                'value_en'   => 'Cairo, Egypt',
                'type'       => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_ar'     => 'رابط فيسبوك',
                'key_en'     => 'facebook_url',
                'value_ar'   => 'https://facebook.com/speechclinic',
                'value_en'   => 'https://facebook.com/speechclinic',
                'type'       => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_ar'     => 'رابط انستجرام',
                'key_en'     => 'instagram_url',
                'value_ar'   => 'https://instagram.com/speechclinic',
                'value_en'   => 'https://instagram.com/speechclinic',
                'type'       => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_ar'     => 'نبذة عن العيادة',
                'key_en'     => 'about',
                'value_ar'   => 'عيادة متخصصة في علاج النطق واللغة',
                'value_en'   => 'A clinic specialized in speech and language therapy',
                'type'       => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_ar'     => 'شعار الموقع',
                'key_en'     => 'logo',
                'value_ar'   => 'settings/logo.png',
                'value_en'   => 'settings/logo.png',
                'type'       => 'image',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
