<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->timestamps();
        });

        // 2. Users
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('role_id')->constrained('roles')->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // 3. User Profiles
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->date('birth_date')->nullable();
            $table->timestamps();
        });

        // 4. Addresses
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('recipient_name');
            $table->string('address_line');
            $table->string('city');
            $table->string('postal_code');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        // 5. Brands
        Schema::create('brands', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('country');
            $table->timestamps();
        });

        // 6A. Categories (BUAT TABEL DULU TANPA FOREIGN KEY)
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // Definisikan kolom parent_id tapi JANGAN pasang constrained dulu
            $table->uuid('parent_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 6B. Categories (BARU PASANG FOREIGN KEY DISINI)
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null'); // Gunakan syntax on() manual
        });

        // 7. Attributes
        Schema::create('attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('type');
            $table->timestamps();
        });

        // 8. Attribute Values
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('attribute_id')->constrained('attributes')->cascadeOnDelete();
            $table->string('value');
            $table->timestamps();
        });

        // 9. Discounts
        Schema::create('discounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('type');
            $table->integer('amount');
            $table->integer('min_purchase')->default(0);
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });
    }
};
