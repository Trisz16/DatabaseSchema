<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Attribute;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    // TAMPILKAN DAFTAR VARIAN DARI PRODUK TERTENTU
    public function index(Product $product)
    {
        // Load varian beserta spesifikasinya (warna, size, dll)
        $variants = $product->variants()->with('attributeValues.attribute')->latest()->paginate(10);
        return view('variants.index', compact('product', 'variants'));
    }

    // FORM TAMBAH VARIAN
    public function create(Product $product)
    {
        // Kita butuh daftar Atribut (Color, Size) dan Pilihan Nilainya (Red, Blue, S, M, L)
        // Agar user bisa memilih kombinasi
        $attributes = Attribute::with('values')->get();

        return view('variants.create', compact('product', 'attributes'));
    }

    // SIMPAN VARIAN
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'sku' => 'required|unique:product_variants,sku',
            'price_adjustment' => 'required|numeric',
            'stock' => 'required|numeric',
            'attribute_values' => 'array' // Array ID dari attribute_values yg dipilih
        ]);

        // 1. Simpan data dasar varian
        $variant = $product->variants()->create([
            'sku' => $request->sku,
            'price_adjustment' => $request->price_adjustment,
            'stock' => $request->stock,
        ]);

        // 2. Hubungkan dengan Atribut (Attach Many-to-Many)
        // Contoh: Attach ID "Merah" dan ID "XL" ke varian ini
        if ($request->has('attribute_values')) {
            $variant->attributeValues()->attach($request->attribute_values);
        }

        return redirect()->route('products.variants.index', $product->id)
            ->with('success', 'Variant added successfully');
    }

    // FORM EDIT
    public function edit(ProductVariant $variant)
    {
        // Load atribut untuk dropdown
        $attributes = Attribute::with('values')->get();

        // Ambil ID nilai atribut yang SUDAH dimiliki varian ini (untuk auto-select)
        $selectedValues = $variant->attributeValues->pluck('id')->toArray();

        return view('variants.edit', compact('variant', 'attributes', 'selectedValues'));
    }

    // UPDATE VARIAN
    public function update(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'sku' => 'required|unique:product_variants,sku,' . $variant->id,
            'price_adjustment' => 'required|numeric',
            'stock' => 'required|numeric',
            'attribute_values' => 'array'
        ]);

        // 1. Update data dasar
        $variant->update([
            'sku' => $request->sku,
            'price_adjustment' => $request->price_adjustment,
            'stock' => $request->stock,
        ]);

        // 2. Sync Atribut (Hapus yang lama, ganti yang baru)
        if ($request->has('attribute_values')) {
            $variant->attributeValues()->sync($request->attribute_values);
        } else {
            $variant->attributeValues()->detach(); // Hapus semua jika tidak ada yang dipilih
        }

        return redirect()->route('products.variants.index', $variant->product_id)
            ->with('success', 'Variant updated successfully');
    }

    // HAPUS VARIAN
    public function destroy(ProductVariant $variant)
    {
        $productId = $variant->product_id;
        $variant->delete();

        return redirect()->route('products.variants.index', $productId)
            ->with('success', 'Variant deleted successfully');
    }

    public function all()
    {
        // Ambil semua varian, load relasi 'product' dan 'attributeValues'
        $variants = ProductVariant::with(['product', 'attributeValues.attribute'])
            ->latest()
            ->paginate(20);

        return view('variants.all', compact('variants'));
    }
}
