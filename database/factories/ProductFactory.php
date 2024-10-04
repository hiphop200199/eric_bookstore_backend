<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $theme_category = ['文學','科技','語言'];
        $language_category = ['中文','英文'];
        return [
           'name'=>fake()->sentence(),
           'price'=>fake()->numberBetween(200,1000),
           'image_source'=>fake()->imageUrl(),
           'theme'=>fake()->randomElement($theme_category),
           'language'=>fake()->randomElement($language_category),
           'author'=>fake()->name(),
           'publisher'=>fake()->company(),
           'published_date'=>fake()->date(),
           'introduction'=>fake()->paragraph(10),
           'stock'=>fake()->numberBetween(0,10),
           'launched_date'=>fake()->dateTimeThisYear()
        ];
    }
}
