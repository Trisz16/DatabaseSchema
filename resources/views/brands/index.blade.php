@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Brand List</h2>
        <a href="{{ route('brands.create') }}" class="btn btn-primary">+ Add New Brand</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Country</th>
                    <th style="width: 200px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($brands as $brand)
                    <tr>
                        <td class="fw-bold">{{ $brand->name }}</td>
                        <td>{{ $brand->country }}</td>
                        <td>
                            <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-warning text-white me-1">
                                Edit
                            </a>

                            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this brand?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">No brands found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $brands->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
