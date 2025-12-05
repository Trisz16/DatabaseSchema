<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(), // Ini akan dicover oleh seeder nanti
            'sku' => strtoupper($this->faker->bothify('SKU-####-????')),
            'price_adjustment' => $this->faker->numberBetween(100000, 5000000),
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
