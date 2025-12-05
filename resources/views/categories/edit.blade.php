@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header bg-warning text-dark">Edit Category</div>
        <div class="card-body">
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" value="{{ $category->slug }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Parent Category</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- No Parent (Root) --</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
