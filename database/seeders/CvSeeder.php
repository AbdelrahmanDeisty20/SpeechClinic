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
                'name'  => 'دينا أحمد سعيد',
                'email' => 'dina.ahmed@example.com',
                'phone' => '01011112222',
                'cv'    => 'cvs/dina_ahmed_cv.pdf',
                'image' => 'cv_images/dina.png',
            ],
            [
                'name'  => 'كريم طارق محمود',
                'email' => 'karim.tarek@example.com',
                'phone' => '01033334444',
                'cv'    => 'cvs/karim_tarek_cv.pdf',
                'image' => 'cv_images/karim.png',
            ],
            [
                'name'  => 'ريهام صلاح الدين',
                'email' => 'reham.salah@example.com',
                'phone' => '01055556666',
                'cv'    => 'cvs/reham_salah_cv.pdf',
                'image' => 'cv_images/reham.png',
            ],
            [
                'name'  => 'يوسف عبد الرحمن فرج',
                'email' => 'youssef.farag@example.com',
                'phone' => '01077778888',
                'cv'    => 'cvs/youssef_farag_cv.pdf',
                'image' => 'cv_images/youssef.png',
            ],
            [
                'name'  => 'نور محمد فتحي',
                'email' => 'nour.fathi@example.com',
                'phone' => '01099990000',
                'cv'    => 'cvs/nour_fathi_cv.pdf',
                'image' => 'cv_images/nour.png',
            ],
        ];

        foreach ($cvs as $cv) {
            Cv::create($cv);
        }
    }
}
