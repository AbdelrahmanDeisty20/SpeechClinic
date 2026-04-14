<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title_ar'       => 'مرحباً بكم في عيادة النطق',
                'title_en'       => 'Welcome to Speech Clinic',
                'description_ar' => 'نقدم أفضل خدمات علاج النطق واللغة للأطفال والبالغين على يد متخصصين معتمدين.',
                'description_en' => 'We provide the best speech and language therapy services for children and adults by certified specialists.',
                'image'          => 'banners/banner1.png',
            ],
            [
                'title_ar'       => 'خدماتنا المتميزة',
                'title_en'       => 'Our Premium Services',
                'description_ar' => 'نوفر جلسات علاجية متخصصة لاضطرابات النطق والصوت واللغة بأحدث الأساليب العلمية.',
                'description_en' => 'We offer specialized therapy sessions for speech, voice, and language disorders using the latest scientific methods.',
                'image'          => 'banners/banner2.png',
            ],
            [
                'title_ar'       => 'احجز جلستك الآن',
                'title_en'       => 'Book Your Session Now',
                'description_ar' => 'تواصل معنا اليوم واحجز جلستك مع أفضل أخصائيي النطق واللغة.',
                'description_en' => 'Contact us today and book your session with the best speech and language specialists.',
                'image'          => 'banners/banner3.png',
            ],
        ];

        foreach ($banners as $banner) {
            Banner::updateOrCreate(
                ['title_en' => $banner['title_en']],
                $banner
            );
        }
    }
}
