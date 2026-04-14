<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        Contact::truncate();

        $contacts = [
            [
                'name'    => 'أحمد محمد السيد',
                'email'   => 'ahmed.elsayed@example.com',
                'phone'   => '01012345678',
                'subject' => 'الاستفسار عن جلسات النطق',
                'message' => 'أريد الاستفسار عن مواعيد الجلسات المتاحة وأسعارها لطفلي البالغ من العمر 5 سنوات الذي يعاني من تأخر في النطق.',
            ],
            [
                'name'    => 'فاطمة علي حسن',
                'email'   => 'fatima.ali@example.com',
                'phone'   => '01123456789',
                'subject' => 'حجز موعد تقييم',
                'message' => 'أرغب في حجز موعد لتقييم اضطراب اللغة لدى ابنتي ذات العشر سنوات.',
            ],
            [
                'name'    => 'محمود حسن إبراهيم',
                'email'   => 'mahmoud.hassan@example.com',
                'phone'   => '01234567890',
                'subject' => 'شكر وتقدير',
                'message' => 'أود أن أتقدم بالشكر الجزيل للفريق الطبي المتميز على الجهد المبذول في علاج ابني خلال الثلاثة أشهر الماضية.',
            ],
            [
                'name'    => 'سارة يوسف عبد الله',
                'email'   => 'sara.youssef@example.com',
                'phone'   => '01098765432',
                'subject' => 'الاستعلام عن التكلفة',
                'message' => 'أريد معرفة تكلفة جلسة التقييم الأولى وما تشمله من خدمات، وهل تتعاملون مع التأمين الصحي؟',
            ],
            [
                'name'    => 'عمر إبراهيم منصور',
                'email'   => 'omar.mansour@example.com',
                'phone'   => '01187654321',
                'subject' => 'استفسار عن فروع العيادة',
                'message' => 'هل يوجد فرع آخر للعيادة في منطقة مدينة نصر أو مصر الجديدة؟',
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
