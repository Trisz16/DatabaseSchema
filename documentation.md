Dokumentasi Proyek: Laravel E-Commerce Admin & Analytics Pipeline
Project Name: Laravel E-Commerce Admin

Stack: Laravel 12, PostgreSQL, Bootstrap 5

Database: Relational (UUID Based)

1. Project Overview
   Aplikasi ini adalah sistem backend dan panel admin untuk manajemen E-Commerce yang dirancang dengan struktur database ternormalisasi. Sistem ini menangani manajemen data master, inventaris produk yang kompleks (multi-varian), manajemen pesanan, pelanggan, serta menyediakan pipeline analitik untuk pelaporan bisnis secara real-time.

2. Database Schema (ERD) & Relationships
   Sistem menggunakan PostgreSQL dengan Primary Key bertipe UUID untuk keamanan dan skalabilitas.

A. User Management (Aktor)
users: Tabel utama kredensial login (Email, Password).

roles: Hak akses (Administrator, Customer).

user_profiles: Informasi biodata (No HP, Gender, Tgl Lahir).

addresses: Alamat pengiriman (Multi-address per user).

Relasi:

users (1 - 1) user_profiles

users (1 - N) addresses

roles (1 - N) users

B. Product Inventory (Katalog)
products: Data induk produk (Nama, Deskripsi, Slug).

brands: Merek produk.

categories: Kategori hirarkis (Self-referencing: Parent -> Child).

product_variants: SKU fisik (Stok, Harga Spesifik, Kode SKU).

attributes: Definisi spesifikasi (Warna, Ukuran, Material).

attribute_values: Nilai spesifikasi (Merah, Biru, XL, L).

Relasi:

products (1 - N) product_variants

product_variants (N - N) attribute_values (via Pivot Table: variant_attribute_values)

C. Transactions (Transaksi)
orders: Header pesanan (User, Alamat, Total Harga, Status).

order_items: Detail barang yang dibeli (Snapshot harga & qty).

payments: Status pembayaran.

shippings: Informasi kurir dan resi.

Relasi:

orders (1 - N) order_items

orders (1 - 1) payments

orders (1 - 1) shippings

Berikut adalah file documentation.md yang lengkap dan profesional sesuai dengan spesifikasi proyek Anda. Dokumentasi ini mencakup penjelasan skema, relasi ERD, dan dokumentasi teknis untuk 3 query analitik utama.

Silakan simpan konten di bawah ini dengan nama file documentation.md di dalam folder root project Anda.

Dokumentasi Proyek: Laravel E-Commerce Admin & Analytics Pipeline
Project Name: Laravel E-Commerce Admin

Stack: Laravel 12, PostgreSQL, Bootstrap 5

Database: Relational (UUID Based)

1. Project Overview
   Aplikasi ini adalah sistem backend dan panel admin untuk manajemen E-Commerce yang dirancang dengan struktur database ternormalisasi. Sistem ini menangani manajemen data master, inventaris produk yang kompleks (multi-varian), manajemen pesanan, pelanggan, serta menyediakan pipeline analitik untuk pelaporan bisnis secara real-time.

2. Database Schema (ERD) & Relationships
   Sistem menggunakan PostgreSQL dengan Primary Key bertipe UUID untuk keamanan dan skalabilitas.

A. User Management (Aktor)
users: Tabel utama kredensial login (Email, Password).

roles: Hak akses (Administrator, Customer).

user_profiles: Informasi biodata (No HP, Gender, Tgl Lahir).

addresses: Alamat pengiriman (Multi-address per user).

Relasi:

users (1 - 1) user_profiles

users (1 - N) addresses

roles (1 - N) users

B. Product Inventory (Katalog)
products: Data induk produk (Nama, Deskripsi, Slug).

brands: Merek produk.

categories: Kategori hirarkis (Self-referencing: Parent -> Child).

product_variants: SKU fisik (Stok, Harga Spesifik, Kode SKU).

attributes: Definisi spesifikasi (Warna, Ukuran, Material).

attribute_values: Nilai spesifikasi (Merah, Biru, XL, L).

Relasi:

products (1 - N) product_variants

product_variants (N - N) attribute_values (via Pivot Table: variant_attribute_values)

C. Transactions (Transaksi)
orders: Header pesanan (User, Alamat, Total Harga, Status).

order_items: Detail barang yang dibeli (Snapshot harga & qty).

payments: Status pembayaran.

shippings: Informasi kurir dan resi.

Relasi:

orders (1 - N) order_items

orders (1 - 1) payments

orders (1 - 1) shippings

3. Analytics Pipeline (SQL Queries)
   Berikut adalah 3 Query Analitik utama yang digunakan dalam fitur "Database Views" (Reports) untuk memantau performa bisnis.

Query 1: Top 5 Produk Terlaris & Total Stok (Product Inventory View)
Tujuan: Menganalisa produk mana yang memiliki varian terbanyak dan memantau total ketersediaan stok gudang gabungan dari semua varian.

```sql
SELECT
    p.name AS product_name,
    b.name AS brand_name,
    c.name AS category_name,
COUNT(pv.id) as variant_count,
COALESCE(SUM(pv.stock), 0) as total_stock
FROM products p
JOIN brands b ON p.brand_id = b.brand_id
JOIN categories c ON p.category_id = c.category_id
LEFT JOIN product_variants pv ON p.id = pv.product_id
GROUP BY p.id, p.name, b.name, c.name
ORDER BY total_stock DESC
LIMIT 5;
```

Query 2: Laporan Omzet Bulanan (Monthly Sales Report)
Tujuan: Melihat tren penjualan, jumlah pesanan sukses vs batal, dan total pendapatan kotor per bulan. Query ini menggunakan fungsi TO_CHAR khusus PostgreSQL.

```sql
SELECT 
    TO_CHAR(created_at, 'YYYY-MM') as month,
    COUNT(id) as total_orders,
    SUM(total_price) as total_revenue,
    COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_orders,
    COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_orders
FROM orders
GROUP BY month
ORDER BY month DESC;
```

Query 3: Top 5 Pelanggan Loyal (Customer Lifetime Value)
Tujuan: Mengidentifikasi pelanggan VIP berdasarkan total uang yang dibelanjakan (Total Spent) dan frekuensi transaksi. Order dengan status 'cancelled' tidak dihitung.
```sql
SELECT 
    u.name AS customer_name, 
    u.email, 
    up.phone,
    COUNT(o.id) as total_transaction_count,
    SUM(o.total_price) as total_spent,
    MAX(o.created_at) as last_order_date
FROM users u
JOIN user_profiles up ON u.id = up.user_id
JOIN orders o ON u.id = o.user_id
WHERE o.status != 'cancelled'
GROUP BY u.id, u.name, u.email, up.phone
ORDER BY total_spent DESC
LIMIT 5;
```
