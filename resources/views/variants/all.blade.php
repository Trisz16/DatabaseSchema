@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Product Variants (Master Stock)</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Specifications</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($variants as $variant)
                    <tr>
                        <td>
                            <a href="{{ route('products.edit', $variant->product_id) }}" class="text-decoration-none fw-bold">
                                {{ $variant->product->name }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $variant->product->brand->name ?? '-' }}</small>
                        </td>
                        <td class="fw-bold text-primary">{{ $variant->sku }}</td>
                        <td>
                            @foreach($variant->attributeValues as $val)
                                <span class="badge bg-secondary mb-1">
                                {{ $val->attribute->name }}: {{ $val->value }}
                            </span>
                            @endforeach
                        </td>
                        <td>{{ number_format($variant->price_adjustment) }}</td>
                        <td>
                            @if($variant->stock <= 5)
                                <span class="badge bg-danger">Low: {{ $variant->stock }}</span>
                            @else
                                <span class="badge bg-success">{{ $variant->stock }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('variants.edit', $variant->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No variants found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{ $variants->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
