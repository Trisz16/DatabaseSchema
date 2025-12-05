<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    // LIST ATTRIBUTES
    public function index()
    {
        // withCount('values') menghitung jumlah nilai yg dimiliki atribut
        $attributes = Attribute::withCount('values')->latest()->paginate(10);
        return view('attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('attributes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,number,color', // Validasi tipe
        ]);

        $attribute = Attribute::create($request->all());

        // Redirect langsung ke halaman Edit agar user bisa langsung isi Values
        return redirect()->route('attributes.edit', $attribute->id)
            ->with('success', 'Attribute created! Now add some values.');
    }

    public function edit(Attribute $attribute)
    {
        // Load values agar muncul di list bawah form edit
        $attribute->load('values');
        return view('attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,number,color',
        ]);

        $attribute->update($request->all());

        return redirect()->route('attributes.index')
            ->with('success', 'Attribute updated successfully');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('attributes.index')
            ->with('success', 'Attribute deleted successfully');
    }

    // --- CUSTOM METHODS FOR VALUES ---

    // Menambah Value baru (misal: Red) ke Atribut (Color)
    public function storeValue(Request $request, Attribute $attribute)
    {
        $request->validate([
            'value' => 'required|string|max:255'
        ]);

        $attribute->values()->create([
            'value' => $request->value
        ]);

        return back()->with('success', 'Value added successfully');
    }

    // Menghapus Value
    public function destroyValue(AttributeValue $attributeValue)
    {
        $attributeValue->delete();
        return back()->with('success', 'Value deleted successfully');
    }
}
