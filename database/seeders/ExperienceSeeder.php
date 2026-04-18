<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Experience::updateOrCreate(
            ['title' => 'الخبرة'],
            ['value' => '10']
        );

        Experience::updateOrCreate(
            ['title' => 'حالات النجاح'],
            ['value' => '100+']
        );
    }
}
