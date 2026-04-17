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
            ['name' => 'امل', 'email' => 'amal@zaid.com', 'password' => 'Amal@123'],
            ['name' => 'طاهره', 'email' => 'tahera@zaid.com', 'password' => 'Tahera@123'],
            ['name' => 'ميرنا حسان', 'email' => 'mirna@zaid.com', 'password' => 'Mirna@123'],
            ['name' => 'منه ايمن', 'email' => 'menna@zaid.com', 'password' => 'Menna@123'],
            ['name' => 'زينب عمرو', 'email' => 'zainab@zaid.com', 'password' => 'Zainab@123'],
            ['name' => 'عفاف', 'email' => 'afaf@zaid.com', 'password' => 'Afaf@123'],
            ['name' => 'امل ايهاب', 'email' => 'amal.ehab@zaid.com', 'password' => 'AmalE@123'],
            ['name' => 'شيماء', 'email' => 'shimaa@zaid.com', 'password' => 'Shimaa@123'],
            ['name' => 'شيرين عبد النبي', 'email' => 'sherine@zaid.com', 'password' => 'Sherine@123'],
            ['name' => 'رحاب', 'email' => 'rehab@zaid.com', 'password' => 'Rehab@123'],
            ['name' => 'تسنيم', 'email' => 'tasneem@zaid.com', 'password' => 'Tasneem@123'],
            ['name' => 'زينب السعيد', 'email' => 'zainab.s@zaid.com', 'password' => 'ZainabS@123'],
            ['name' => 'هايدي', 'email' => 'heidy@zaid.com', 'password' => 'Heidy@123'],
            ['name' => 'جيهان', 'email' => 'gehan@zaid.com', 'password' => 'Gehan@123'],
            ['name' => 'آلاء حسين', 'email' => 'alaa@zaid.com', 'password' => 'Alaa@123'],
            ['name' => 'ايه جمعه', 'email' => 'aya.gomaa@zaid.com', 'password' => 'AyaG@123'],
            ['name' => 'ساره حواس', 'email' => 'sara.hawas@zaid.com', 'password' => 'SaraH@123'],
            ['name' => 'نجاة', 'email' => 'nagaa@zaid.com', 'password' => 'Nagaa@123'],
            ['name' => 'ساره ايمن', 'email' => 'sara.ayman@zaid.com', 'password' => 'SaraA@123'],
            ['name' => 'ايه حاتم', 'email' => 'aya.hatem@zaid.com', 'password' => 'AyaH@123'],
            ['name' => 'نور هان', 'email' => 'nourhan@zaid.com', 'password' => 'Nourhan@123'],
            ['name' => 'سماح', 'email' => 'samah@zaid.com', 'password' => 'Samah@123'],
            ['name' => 'إسراء محفوظ', 'email' => 'esraa@zaid.com', 'password' => 'Esraa@123'],
            ['name' => 'مريم سعد', 'email' => 'mariam@zaid.com', 'password' => 'Mariam@123'],
            ['name' => 'منه سعد', 'email' => 'menna.saad@zaid.com', 'password' => 'MennaS@123'],
            ['name' => 'هند السيد', 'email' => 'hend@zaid.com', 'password' => 'Hend@123'],
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
                    'password' => Hash::make($data['password']),
                    'type' => 'specialist',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
