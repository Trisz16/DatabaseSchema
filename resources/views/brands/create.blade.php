@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Add New Brand</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('brands.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Brand Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Samsung" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Country of Origin</label>
                        <input type="text" name="country" class="form-control" placeholder="e.g. South Korea" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('brands.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Save Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
