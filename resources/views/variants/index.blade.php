@extends('layout.app')

@section('content')
    <div class="mb-3">
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">&larr; Back to Products</a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Variants for: <span class="text-primary">{{ $product->name }}</span></h3>
        <a href="{{ route('products.variants.create', $product->id) }}" class="btn btn-primary">+ Add Variant</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                <tr>
                    <th>SKU</th>
                    <th>Specifications (Attributes)</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($variants as $variant)
                    <tr>
                        <td class="fw-bold">{{ $variant->sku }}</td>
                        <td>
                            @foreach($variant->attributeValues as $val)
                                <span class="badge bg-secondary">
                                {{ $val->attribute->name }}: {{ $val->value }}
                            </span>
                            @endforeach
                            @if($variant->attributeValues->isEmpty())
                                <span class="text-muted small">No specs</span>
                            @endif
                        </td>
                        <td>{{ number_format($variant->price_adjustment) }}</td>
                        <td>
                            @if($variant->stock > 0)
                                <span class="badge bg-success">{{ $variant->stock }}</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('variants.edit', $variant->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('variants.destroy', $variant->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete SKU {{ $variant->sku }}?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No variants yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $variants->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
