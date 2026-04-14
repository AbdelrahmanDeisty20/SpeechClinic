<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            [
                'name'    => 'أحمد محمد',
                'email'   => 'ahmed.mohamed@example.com',
                'phone'   => '01012345678',
                'subject' => 'الاستفسار عن جلسات النطق',
                'message' => 'أريد الاستفسار عن مواعيد الجلسات المتاحة وأسعارها لطفلي البالغ من العمر 5 سنوات.',
            ],
            [
                'name'    => 'فاطمة علي',
                'email'   => 'fatima.ali@example.com',
                'phone'   => '01123456789',
                'subject' => 'حجز موعد',
                'message' => 'أرغب في حجز موعد لتقييم اضطراب النطق لدى ابنتي.',
            ],
            [
                'name'    => 'محمود حسن',
                'email'   => 'mahmoud.hassan@example.com',
                'phone'   => '01234567890',
                'subject' => 'شكر وتقدير',
                'message' => 'أود أن أتقدم بالشكر الجزيل للفريق الطبي على الجهد المبذول في علاج ابني.',
            ],
            [
                'name'    => 'سارة يوسف',
                'email'   => 'sara.youssef@example.com',
                'phone'   => '01098765432',
                'subject' => 'الاستعلام عن التكلف',
                'message' => 'أريد معرفة تكلفة جلسة التقييم الأولى وما تشمله من خدمات.',
            ],
            [
                'name'    => 'عمر إبراهيم',
                'email'   => 'omar.ibrahim@example.com',
                'phone'   => '01187654321',
                'subject' => 'استفسار عن الموقع',
                'message' => 'هل يوجد فرع في منطقة مدينة نصر أو قريب منها؟',
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
