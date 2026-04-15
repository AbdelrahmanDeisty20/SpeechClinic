<?php

namespace Database\Seeders;

use App\Models\Cv;
use Illuminate\Database\Seeder;

class CvSeeder extends Seeder
{
    public function run(): void
    {
        Cv::truncate();

        $cvs = [
            [
                'name_ar'        => 'دينا أحمد سعيد',
                'name_en'        => 'Dina Ahmed Said',
                'title_ar'       => 'أخصائي تخاطب',
                'title_en'       => 'Speech Therapist',
                'description_ar' => 'خبرة ٥ سنوات في علاج اضطرابات النطق والكلام لدى الأطفال.',
                'description_en' => '5 years of experience in treating speech and language disorders in children.',
                'image'          => 'dina.png',
            ],
            [
                'name_ar'        => 'كريم طارق محمود',
                'name_en'        => 'Karim Tarek Mahmoud',
                'title_ar'       => 'معالج نفسي',
                'title_en'       => 'Psychotherapist',
                'description_ar' => 'متخصص في تعديل السلوك وصعوبات التعلم.',
                'description_en' => 'Specialized in behavior modification and learning disabilities.',
                'image'          => 'karim.png',
            ],
            [
                'name_ar'        => 'ريهام صلاح الدين',
                'name_en'        => 'Reham Salah El-Din',
                'title_ar'       => 'أخصائي تنمية مهارات',
                'title_en'       => 'Skills Development Specialist',
                'description_ar' => 'خبيرة في تنمية المهارات الإدراكية والاجتماعية.',
                'description_en' => 'Expert in cognitive and social skills development.',
                'image'          => 'reham.png',
            ],
            [
                'name_ar'        => 'يوسف عبد الرحمن فرج',
                'name_en'        => 'Youssef Abdelrahman Farag',
                'title_ar'       => 'أخصائي تخاطب وتعديل سلوك',
                'title_en'       => 'Speech and Behavior Specialist',
                'description_ar' => 'متخصص في دمج ذوي الاحتياجات الخاصة وتطوير قدراتهم التواصلية.',
                'description_en' => 'Specialized in integrating people with special needs and developing their communication skills.',
                'image'          => 'youssef.png',
            ],
            [
                'name_ar'        => 'نور محمد فتحي',
                'name_en'        => 'Nour Mohamed Fathi',
                'title_ar'       => 'استشاري تربية خاصة',
                'title_en'       => 'Special Education Consultant',
                'description_ar' => 'خبرة طويلة في المناهج التعليمية المتخصصة.',
                'description_en' => 'Long experience in specialized educational curricula.',
                'image'          => 'nour.png',
            ],
        ];

        foreach ($cvs as $cv) {
            Cv::create($cv);
        }
    }
}
