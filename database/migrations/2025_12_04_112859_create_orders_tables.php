<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 15. Carts (Keranjang Belanja)
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        // 16. Cart Items
        Schema::create('cart_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cart_id')->constrained('carts')->cascadeOnDelete();
            $table->foreignUuid('variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });

        // 17. Orders
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('address_id')->constrained('addresses'); // Jangan cascade delete agar riwayat alamat tersimpan
            $table->integer('total_price');
            $table->string('status')->default('pending'); // pending, paid, shipped, completed, cancelled
            $table->timestamps();
        });

        // 18. Order Items
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignUuid('variant_id')->constrained('product_variants'); // Jika varian dihapus, order history tetap butuh referensi (opsional set null)
            $table->integer('quantity');
            $table->integer('price_per_unit');
            $table->integer('subtotal');
            $table->timestamps();
        });

        // 19. Payments
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('method'); // bank_transfer, credit_card
            $table->string('status'); // pending, success, failed
            $table->timestamp('transaction_time')->useCurrent();
            $table->timestamps();
        });

        // 20. Shippings
        Schema::create('shippings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('courier');
            $table->string('tracking_number')->nullable();
            $table->integer('cost')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shippings');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
