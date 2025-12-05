@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Product List</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td><span class="badge bg-info">{{ $product->brand->name ?? '-' }}</span></td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>{{ Str::limit($product->description, 50) }}</td>
                        <td>
                            <a href="{{ route('products.variants.index', $product->id) }}" class="btn btn-sm btn-info text-white me-1">
                                Variants
                            </a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
