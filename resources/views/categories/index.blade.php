@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Categories</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Add Category</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Parent Category</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td class="fw-bold">{{ $category->name }}</td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td>
                            @if($category->parent)
                                <span class="badge bg-secondary">{{ $category->parent->name }}</span>
                            @else
                                <span class="badge bg-success">Root (Induk)</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
