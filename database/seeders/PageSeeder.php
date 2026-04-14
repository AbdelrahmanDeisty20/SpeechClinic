<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title_ar' => 'من نحن',
                'title_en' => 'About Us',
                'content_ar' => 'محتوى صفحة من نحن هنا...',
                'content_en' => 'About Us content goes here...',
            ],
            [
                'title_ar' => 'الشروط والأحكام',
                'title_en' => 'Terms and Conditions',
                'content_ar' => 'محتوى الشروط والأحكام هنا...',
                'content_en' => 'Terms and Conditions content goes here...',
            ],
            [
                'title_ar' => 'سياسة الخصوصية',
                'title_en' => 'Privacy Policy',
                'content_ar' => 'محتوى سياسة الخصوصية هنا...',
                'content_en' => 'Privacy Policy content goes here...',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['title_en' => $page['title_en']], $page);
        }

        // Also create some random pages
        Page::factory(2)->create();
    }
}
