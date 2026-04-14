<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::truncate();

        Page::insert([
            [
                'title_ar'   => 'من نحن',
                'title_en'   => 'About Us',
                'content_ar' => 'عيادة النطق هي مركز متخصص في علاج اضطرابات النطق واللغة والصوت للأطفال والبالغين. تأسست العيادة على يد نخبة من أفضل أخصائيي النطق واللغة في مصر، وتهدف إلى تقديم رعاية علاجية شاملة ومتكاملة بأعلى المعايير المهنية.',
                'content_en' => 'Speech Clinic is a specialized center for treating speech, language, and voice disorders for children and adults. Founded by a team of Egypt\'s best speech-language pathologists, the clinic aims to provide comprehensive therapeutic care at the highest professional standards.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_ar'   => 'سياسة الخصوصية',
                'title_en'   => 'Privacy Policy',
                'content_ar' => 'نحن في عيادة النطق نلتزم بالحفاظ على خصوصية بياناتك الشخصية. لن يتم مشاركة أي بيانات خاصة بك مع أطراف ثالثة دون موافقتك الصريحة. يحق لك في أي وقت طلب الاطلاع على بياناتك أو تعديلها أو حذفها.',
                'content_en' => 'At Speech Clinic, we are committed to protecting your personal data. No personal data will be shared with third parties without your explicit consent. You have the right at any time to request access to, correction of, or deletion of your data.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_ar'   => 'الشروط والأحكام',
                'title_en'   => 'Terms and Conditions',
                'content_ar' => 'باستخدامك لخدمات عيادة النطق فأنت توافق على الشروط والأحكام المنصوص عليها. تحتفظ العيادة بحق تعديل هذه الشروط في أي وقت مع الإشعار المسبق للمستخدمين.',
                'content_en' => 'By using Speech Clinic\'s services, you agree to the terms and conditions set forth. The clinic reserves the right to modify these terms at any time with prior notice to users.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_ar'   => 'تواصل معنا',
                'title_en'   => 'Contact Us',
                'content_ar' => 'يسعدنا تواصلك معنا في أي وقت. يمكنك التواصل عبر البريد الإلكتروني أو الهاتف أو زيارة أقرب فرع لنا. فريقنا جاهز للإجابة على جميع استفساراتك.',
                'content_en' => 'We are happy to hear from you at any time. You can reach us via email, phone, or by visiting your nearest branch. Our team is ready to answer all your inquiries.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
