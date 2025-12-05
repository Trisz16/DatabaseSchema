<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DatabaseViewController;

// ROUTE UTAMA (Langsung Dashboard)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// CRUD ROUTES (Tanpa Middleware Auth)
Route::resource('products', ProductController::class);

// Contoh untuk Brands (Silakan buat Controller & View-nya dengan pola yang sama seperti Products)
 Route::resource('brands', BrandController::class);

Route::resource('categories', CategoryController::class);

Route::resource('attributes', AttributeController::class);

Route::post('attributes/{attribute}/values', [AttributeController::class, 'storeValue'])->name('attributes.values.store');
Route::delete('attributes/values/{attributeValue}', [AttributeController::class, 'destroyValue'])->name('attributes.values.destroy');

Route::resource('products.variants', ProductVariantController::class)->shallow();

Route::get('all-variants', [ProductVariantController::class, 'all'])->name('variants.all');

Route::resource('orders', OrderController::class)->except(['create', 'store']);

Route::resource('customers', CustomerController::class);

Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('products', [DatabaseViewController::class, 'productView'])->name('products');
    Route::get('orders', [DatabaseViewController::class, 'orderView'])->name('orders');

    // --- TAMBAHAN BARU ---
    Route::get('sales', [DatabaseViewController::class, 'salesReport'])->name('sales');
    Route::get('top-customers', [DatabaseViewController::class, 'topCustomers'])->name('top_customers');
});
