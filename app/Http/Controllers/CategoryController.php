<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Load data parent agar bisa menampilkan nama induknya
        $categories = Category::with('parent')->latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        // Ambil semua kategori untuk dijadikan pilihan Parent
        $parents = Category::all();
        return view('categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id', // Boleh kosong jika dia Induk
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        // Ambil semua kategori KECUALI dirinya sendiri (agar tidak loop)
        $parents = Category::where('id', '!=', $category->id)->get();
        return view('categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
