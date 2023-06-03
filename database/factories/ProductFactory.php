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
        return [
            'name' => $this->faker->word,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'description_html' => $this->faker->paragraph,
            'sequence' => $this->faker->randomNumber(),
            'product_sequence' => $this->faker->randomNumber(),
            'product_category_id' => \App\Models\ProductCategory::factory()->create()->id,
        ];
    }
}
