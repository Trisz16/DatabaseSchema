@extends('layout.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Edit Brand</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('brands.update', $brand->id) }}" method="POST">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label class="form-label">Brand Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $brand->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Country of Origin</label>
                            <input type="text" name="country" class="form-control" value="{{ $brand->country }}" required>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('brands.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Brand</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
