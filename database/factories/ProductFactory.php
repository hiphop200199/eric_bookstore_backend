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
        $image_category = ['https://cdn.pixabay.com/photo/2024/06/16/15/23/book-8833643_640.jpg','https://cdn.pixabay.com/photo/2023/03/12/20/58/ai-generated-7847847_640.jpg','https://cdn.pixabay.com/photo/2024/04/02/15/52/ai-generated-8671101_640.png','https://cdn.pixabay.com/photo/2024/02/24/22/38/ai-generated-8594854_640.png','https://cdn.pixabay.com/photo/2023/03/17/14/26/bear-7858736_640.jpg'];
        return [
           'name'=>fake()->sentence(),
           'price'=>fake()->numberBetween(200,1000),
           'image_source'=>fake()->randomElement($image_category),
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
