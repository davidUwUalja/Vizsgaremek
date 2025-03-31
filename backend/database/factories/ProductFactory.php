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
            'name_hu' => fake()->word(),                     
            'name_en' => fake()->word(),                     
            'material_hu' => fake()->word(),                 
            'material_en' => fake()->word(),                 
            'description_hu' => fake()->text(),              
            'description_en' => fake()->text(),              
            'price_hu' => fake()->randomFloat(2, 1000, 100000), 
            'price_en' => fake()->randomFloat(2, 10, 1000),  
            'image_url' => fake()->imageUrl(),               
            'stock' => fake()->numberBetween(0, 100),        
            'category_hu' => fake()->word(),                 
            'category_en' => fake()->word(),                 
        ];
    }
}
