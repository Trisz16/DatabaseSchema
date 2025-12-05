@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">Add New Category</div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" placeholder="e.g. smart-phones" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Parent Category (Optional)</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- No Parent (Root) --</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Biarkan kosong jika ini adalah kategori induk utama.</small>
                </div>

                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
