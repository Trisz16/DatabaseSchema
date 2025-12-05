<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true); // Contoh: "Super Gaming Laptop"
        return [
            // Ambil brand/category acak dari yg sudah ada, atau buat baru jika kosong
            'brand_id' => Brand::inRandomOrder()->first()->id ?? Brand::factory(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(),
        ];
    }
}
