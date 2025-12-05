<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseViewController extends Controller
{
    // VIEW 1: Gabungan Produk, Brand, Kategori, dan Total Stok Varian
    public function productView()
    {
        $data = DB::table('products')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            // Left Join ke variants untuk menghitung stok
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->select(
                'products.name as product_name',
                'brands.name as brand_name',
                'categories.name as category_name',
                'products.slug',
                DB::raw('COUNT(product_variants.id) as variant_count'),
                DB::raw('COALESCE(SUM(product_variants.stock), 0) as total_stock'),
                DB::raw('MIN(product_variants.price_adjustment) as lowest_price')
            )
            ->groupBy('products.id', 'products.name', 'brands.name', 'categories.name', 'products.slug')
            ->orderBy('products.name', 'asc')
            ->paginate(10);

        return view('reports.product_view', compact('data'));
    }

    // VIEW 2: Gabungan Order, Customer, Payment, Shipping
    public function orderView()
    {
        $data = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('payments', 'orders.id', '=', 'payments.order_id')
            ->leftJoin('shippings', 'orders.id', '=', 'shippings.order_id')
            ->select(
                'orders.id as order_id',
                'orders.created_at',
                'orders.status as order_status',
                'orders.total_price',
                'users.name as customer_name',
                'users.email as customer_email',
                'payments.method as payment_method',
                'payments.status as payment_status',
                'shippings.courier',
                'shippings.tracking_number'
            )
            ->orderBy('orders.created_at', 'desc')
            ->paginate(10);

        return view('reports.order_view', compact('data'));
    }

    public function salesReport()
    {
        // Query khusus PostgreSQL untuk group by bulan
        $data = DB::table('orders')
            ->select(
                DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month"), // Format Tahun-Bulan
                DB::raw('COUNT(id) as total_orders'),
                DB::raw('SUM(total_price) as total_revenue'),
                DB::raw("COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_orders"),
                DB::raw("COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_orders")
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get(); // Gunakan get() karena datanya tidak banyak (hanya 12-24 baris biasanya)

        return view('reports.sales_view', compact('data'));
    }

    // VIEW 4: Top Pelanggan (Top Spenders)
    public function topCustomers()
    {
        $data = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id') // Join profil untuk ambil No HP
            ->select(
                'users.name',
                'users.email',
                'user_profiles.phone',
                DB::raw('COUNT(orders.id) as total_transaction_count'),
                DB::raw('SUM(orders.total_price) as total_spent'),
                DB::raw('MAX(orders.created_at) as last_order_date')
            )
            ->where('orders.status', '!=', 'cancelled') // Jangan hitung order batal
            ->groupBy('users.id', 'users.name', 'users.email', 'user_profiles.phone')
            ->orderByDesc('total_spent') // Urutkan dari yg paling boros
            ->limit(20) // Ambil Top 20 saja
            ->get();

        return view('reports.customer_view', compact('data'));
    }
}
