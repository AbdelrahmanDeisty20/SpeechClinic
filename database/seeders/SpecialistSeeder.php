<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SpecialistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialists = [
            ['name' => 'امل', 'email' => 'amal@zaid.com'],
            ['name' => 'طاهره', 'email' => 'tahera@zaid.com'],
            ['name' => 'ميرنا حسان', 'email' => 'mirna@zaid.com'],
            ['name' => 'منه ايمن', 'email' => 'menna@zaid.com'],
            ['name' => 'زينب عمرو', 'email' => 'zainab@zaid.com'],
            ['name' => 'عفاف', 'email' => 'afaf@zaid.com'],
            ['name' => 'امل ايهاب', 'email' => 'amal.ehab@zaid.com'],
            ['name' => 'شيماء', 'email' => 'shimaa@zaid.com'],
            ['name' => 'شيرين عبد النبي', 'email' => 'sherine@zaid.com'],
            ['name' => 'رحاب', 'email' => 'rehab@zaid.com'],
            ['name' => 'تسنيم', 'email' => 'tasneem@zaid.com'],
            ['name' => 'زينب السعيد', 'email' => 'zainab.s@zaid.com'],
            ['name' => 'هايدي', 'email' => 'heidy@zaid.com'],
            ['name' => 'جيهان', 'email' => 'gehan@zaid.com'],
            ['name' => 'آلاء حسين', 'email' => 'alaa@zaid.com'],
            ['name' => 'ايه جمعه', 'email' => 'aya.gomaa@zaid.com'],
            ['name' => 'ساره حواس', 'email' => 'sara.hawas@zaid.com'],
            ['name' => 'نجاة', 'email' => 'nagaa@zaid.com'],
            ['name' => 'ساره ايمن', 'email' => 'sara.ayman@zaid.com'],
            ['name' => 'ايه حاتم', 'email' => 'aya.hatem@zaid.com'],
            ['name' => 'نور هان', 'email' => 'nourhan@zaid.com'],
            ['name' => 'سماح', 'email' => 'samah@zaid.com'],
            ['name' => 'إسراء محفوظ', 'email' => 'esraa@zaid.com'],
            ['name' => 'مريم سعد', 'email' => 'mariam@zaid.com'],
            ['name' => 'منه سعد', 'email' => 'menna.saad@zaid.com'],
            ['name' => 'هند السيد', 'email' => 'hend@zaid.com'],
        ];

        foreach ($specialists as $data) {
            $nameParts = explode(' ', $data['name'], 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'password' => Hash::make('12345678'), // Unified 8-character password
                    'type' => 'specialist',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
