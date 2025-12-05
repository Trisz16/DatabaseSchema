@extends('layout.app')

@section('content')
    <div class="card" style="max-width: 600px; margin: auto;">
        <div class="card-header bg-primary text-white">Create New Attribute</div>
        <div class="card-body">
            <form action="{{ route('attributes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Attribute Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Color, Size, Material" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Input Type</label>
                    <select name="type" class="form-select" required>
                        <option value="text">Text (e.g. Red, XL, Cotton)</option>
                        <option value="number">Number (e.g. 42, 128)</option>
                        <option value="color">Color Swatch (Hex Code)</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('attributes.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success">Create & Add Values</button>
                </div>
            </form>
        </div>
    </div>
@endsection
