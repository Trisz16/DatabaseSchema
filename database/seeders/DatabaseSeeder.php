<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shipping;
use App\Models\Attribute;
use App\Models\OrderItem;
use App\Models\UserProfile;
use App\Models\ProductImage;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Tambahkan import ini

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // BAGIAN 1: DATA MANUAL (FIXED DATA)
        // ==========================================

        // 1. ROLES
        $roleAdmin = Role::create(['name' => 'Administrator']);
        $roleCustomer = Role::create(['name' => 'Customer']);

        // 2. USERS
        $admin = User::create([
            'role_id' => $roleAdmin->id,
            'name' => 'System Administrator',
            'email' => 'admin@store.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $john = User::create([
            'role_id' => $roleCustomer->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // 3. PROFILES & ADDRESSES
        UserProfile::create([
            'user_id' => $john->id,
            'phone' => '+1-555-0199',
            'gender' => 'Male',
            'birth_date' => '1995-07-15',
        ]);

        DB::table('addresses')->insert([
            'id' => (string) Str::uuid(),
            'user_id' => $john->id,
            'recipient_name' => 'John Doe (Home)',
            'address_line' => '123 Broadway Ave',
            'city' => 'New York',
            'postal_code' => '10012',
            'is_primary' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. BRANDS
        $apple = Brand::create(['name' => 'Apple', 'country' => 'USA']);
        $samsung = Brand::create(['name' => 'Samsung', 'country' => 'South Korea']);
        // Tambahan brand agar variasi lebih banyak
        $brands = collect([$apple, $samsung]);
        $brands->push(Brand::create(['name' => 'Sony', 'country' => 'Japan']));
        $brands->push(Brand::create(['name' => 'Logitech', 'country' => 'Swiss']));
        $brands->push(Brand::create(['name' => 'Asus', 'country' => 'Taiwan']));

        // 5. CATEGORIES
        $catElectronics = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
        $catSmartphones = Category::create(['parent_id' => $catElectronics->id, 'name' => 'Smartphones', 'slug' => 'smartphones']);
        // Tambahan kategori
        $catLaptops = Category::create(['parent_id' => $catElectronics->id, 'name' => 'Laptops', 'slug' => 'laptops']);
        $catAccessories = Category::create(['parent_id' => $catElectronics->id, 'name' => 'Accessories', 'slug' => 'accessories']);
        $categories = collect([$catSmartphones, $catLaptops, $catAccessories]);

        // 6. ATTRIBUTES & VALUES
        $attrColor = Attribute::create(['name' => 'Color', 'type' => 'text']);
        $attrStorage = Attribute::create(['name' => 'Storage', 'type' => 'text']);

        $valTitanium = AttributeValue::create(['attribute_id' => $attrColor->id, 'value' => 'Titanium Natural']);
        $valBlack = AttributeValue::create(['attribute_id' => $attrColor->id, 'value' => 'Phantom Black']);
        $val256GB = AttributeValue::create(['attribute_id' => $attrStorage->id, 'value' => '256GB']);
        $val512GB = AttributeValue::create(['attribute_id' => $attrStorage->id, 'value' => '512GB']);

        // 7. PRODUCT MANUAL (iPhone 15)
        $iphone = Product::create([
            'brand_id' => $apple->id,
            'category_id' => $catSmartphones->id,
            'name' => 'iPhone 15 Pro',
            'slug' => 'iphone-15-pro',
            'description' => 'The first iPhone to feature an aerospace-grade titanium design.',
        ]);

        // 8. PRODUCT IMAGES
        ProductImage::create([
            'product_id' => $iphone->id,
            'image_url' => 'uploads/products/iphone15pro.jpg',
            'is_thumbnail' => true,
        ]);

        // 9. VARIANTS
        $variant = ProductVariant::create([
            'product_id' => $iphone->id,
            'sku' => 'IP15P-NAT-256',
            'price_adjustment' => 999,
            'stock' => 50,
        ]);

        // 10. VARIANT ATTRIBUTES
        DB::table('variant_attribute_values')->insert([
            ['id' => (string) Str::uuid(), 'variant_id' => $variant->id, 'attribute_value_id' => $valTitanium->id],
            ['id' => (string) Str::uuid(), 'variant_id' => $variant->id, 'attribute_value_id' => $val256GB->id],
        ]);

        // 11-14. ORDER MANUAL (John Doe)
        $addressId = DB::table('addresses')->where('user_id', $john->id)->value('id');
        $order = Order::create([
            'user_id' => $john->id,
            'address_id' => $addressId,
            'total_price' => 1019,
            'status' => 'processing',
            'created_at' => now()->subDays(2), // Mundurkan tanggal biar variatif
        ]);
        OrderItem::create([
            'order_id' => $order->id,
            'variant_id' => $variant->id,
            'quantity' => 1,
            'price_per_unit' => 999,
            'subtotal' => 999,
        ]);
        Payment::create(['order_id' => $order->id, 'method' => 'credit_card', 'status' => 'completed']);
        Shipping::create(['order_id' => $order->id, 'courier' => 'DHL Express', 'tracking_number' => 'DHL999', 'cost' => 20]);
        Review::create(['user_id' => $john->id, 'product_id' => $iphone->id, 'rating' => 5, 'comment' => 'Amazing phone!']);


        // ==========================================
        // BAGIAN 2: DATA OTOMATIS (FACTORY - 50 RECORDS)
        // ==========================================
        $this->command->info('Sedang membuat 50 Produk Dummy...');

        // Pastikan Factory Product & Variant sudah dibuat sebelumnya
        Product::factory(50)->make()->each(function ($product) use ($brands, $categories) {
            // Override random ID dengan ID yang valid dari database
            $product->brand_id = $brands->random()->id;
            $product->category_id = $categories->random()->id;
            $product->save(); // Simpan Produk

            // Buat 1-3 Varian untuk setiap produk
            $variants = ProductVariant::factory(rand(1, 3))->create([
                'product_id' => $product->id
            ]);

            // Hubungkan varian dengan Atribut Acak
            $variants->each(function ($variant) {
                // Ambil 2 atribut value secara acak (misal: 1 warna, 1 storage)
                $randomAttrs = AttributeValue::inRandomOrder()->limit(2)->get();
                foreach($randomAttrs as $attr) {
                    DB::table('variant_attribute_values')->insert([
                        'id' => (string) Str::uuid(),
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $attr->id
                    ]);
                }
            });
        });

        // ==========================================
        // BAGIAN 3: ORDER DUMMY TAMBAHAN
        // ==========================================
        $this->command->info('Sedang membuat Transaksi Dummy...');

        // Buat 5 User Customer Tambahan
        $dummyCustomers = User::factory(5)->create(['role_id' => $roleCustomer->id]);

        // Buat Profil & Alamat untuk dummy customer
        $dummyCustomers->each(function($u) {
            UserProfile::create(['user_id' => $u->id, 'phone' => '08123456789', 'gender' => 'Male']);
            DB::table('addresses')->insert([
                'id' => (string) Str::uuid(), 'user_id' => $u->id, 'recipient_name' => $u->name,
                'address_line' => 'Random St.', 'city' => 'Jakarta', 'postal_code' => '12345', 'is_primary' => true
            ]);
        });

        // Buat Order Acak
        foreach(range(1, 30) as $i) {
            $randomUser = $dummyCustomers->random();
            $randomAddress = DB::table('addresses')->where('user_id', $randomUser->id)->value('id');
            $randomVariant = ProductVariant::inRandomOrder()->first();

            $order = Order::create([
                'user_id' => $randomUser->id,
                'address_id' => $randomAddress,
                'total_price' => $randomVariant->price_adjustment + 50, // Harga + Ongkir
                'status' => fake()->randomElement(['completed', 'shipped', 'cancelled']),
                'created_at' => fake()->dateTimeBetween('-3 months', 'now'), // Tanggal acak 3 bulan terakhir
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'variant_id' => $randomVariant->id,
                'quantity' => 1,
                'price_per_unit' => $randomVariant->price_adjustment,
                'subtotal' => $randomVariant->price_adjustment
            ]);

            Payment::create([
                'order_id' => $order->id,
                'method' => 'bank_transfer',
                'status' => 'success',
                'transaction_time' => $order->created_at
            ]);

            Shipping::create([
                'order_id' => $order->id,
                'courier' => 'JNE',
                'cost' => 50
            ]);
        }

        $this->command->info('SELESAI! Database telah terisi Data Manual + 50 Produk Dummy + Transaksi.');
    }
}
