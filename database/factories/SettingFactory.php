<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key_ar'   => 'مفتاح ' . fake()->unique()->word(),
            'key_en'   => 'key_' . fake()->unique()->word(),
            'value_ar' => fake()->sentence(),
            'value_en' => fake()->sentence(),
            'type'     => fake()->randomElement(['text', 'image']),
        ];
    }
}
