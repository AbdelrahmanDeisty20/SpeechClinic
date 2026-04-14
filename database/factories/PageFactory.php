<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_ar' => 'عنوان صفحة ' . fake()->sentence(),
            'title_en' => 'Page Title ' . fake()->sentence(),
            'content_ar' => 'محتوى صفحة ' . fake()->text(),
            'content_en' => 'Page Content ' . fake()->text(),
        ];
    }
}
