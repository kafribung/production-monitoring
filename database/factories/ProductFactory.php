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
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'price' => fake()->randomNumber(6, true),
            'stock_first' => fake()->numberBetween(0, 100),
            'description' => fake()->paragraph(2, false),
            'material_id' => rand(1, 9),
            'category_id' => rand(1, 4),
            'created_by' => 1,
        ];
    }
}
