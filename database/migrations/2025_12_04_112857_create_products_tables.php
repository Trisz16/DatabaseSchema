<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 10. Products
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->foreignUuid('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 11. Product Images
        Schema::create('product_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('image_url');
            $table->boolean('is_thumbnail')->default(false);
            $table->timestamps();
        });

        // 12. Product Variants (SKU)
        Schema::create('product_variants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('sku')->unique();
            $table->integer('price_adjustment')->default(0); // Tambahan harga dari base price (opsional) atau harga final
            $table->integer('stock')->default(0);
            $table->timestamps();
        });

        // 13. Variant Attribute Values (Pivot Table: Varian ini warnanya apa)
        Schema::create('variant_attribute_values', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('variant_id')->constrained('product_variants')->cascadeOnDelete();
            // Perhatikan nama tabel tujuan constraint harus benar
            $table->foreignUuid('attribute_value_id')->constrained('attribute_values')->cascadeOnDelete();
            $table->timestamps();
        });

        // 14. Reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('variant_attribute_values');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};
