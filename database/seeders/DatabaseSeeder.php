<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GenderSeeder::class,
            NationalitySeeder::class,
            BannerSeeder::class,
            BranchSeeder::class,
            ContactSeeder::class,
            CvSeeder::class,
            PageSeeder::class,
            SettingSeeder::class,
        ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

