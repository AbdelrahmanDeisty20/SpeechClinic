<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_ar' => 'عنوان عربي ' . fake()->sentence(),
            'title_en' => 'English Title ' . fake()->sentence(),
            'description_ar' => 'وصف عربي ' . fake()->paragraph(),
            'description_en' => 'English Description ' . fake()->paragraph(),
            'image' => 'banners/dummy.png',
        ];
    }
}
