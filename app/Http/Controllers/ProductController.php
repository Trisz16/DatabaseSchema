<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Eager load brand dan category agar query ringan
        $products = Product::with(['brand', 'category'])->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        // Kita butuh data brand & category untuk dropdown
        $brands = Brand::all();
        $categories = Category::whereNotNull('parent_id')->get(); // Ambil sub-kategori saja
        return view('products.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'brand_id' => 'required',
            'category_id' => 'required',
        ]);

        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $brands = Brand::all();
        $categories = Category::whereNotNull('parent_id')->get();
        return view('products.edit', compact('product', 'brands', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id,
            'brand_id' => 'required',
            'category_id' => 'required',
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
