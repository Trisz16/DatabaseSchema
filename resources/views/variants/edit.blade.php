@extends('layout.app')

@section('content')
    <div class="card" style="max-width: 700px; margin: auto;">
        <div class="card-header bg-warning text-dark">
            Edit Variant: <strong>{{ $variant->sku }}</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('variants.update', $variant->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" value="{{ $variant->sku }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" value="{{ $variant->stock }}" class="form-control" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Price</label>
                    <input type="number" name="price_adjustment" value="{{ $variant->price_adjustment }}" class="form-control" required>
                </div>

                <hr>
                <h5 class="mb-3 text-secondary">Specifications</h5>

                <div class="row">
                    @foreach($attributes as $attr)
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ $attr->name }}</label>
                            <select name="attribute_values[]" class="form-select">
                                <option value="">-- Select {{ $attr->name }} --</option>
                                @foreach($attr->values as $val)
                                    <option value="{{ $val->id }}" {{ in_array($val->id, $selectedValues) ? 'selected' : '' }}>
                                        {{ $val->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('products.variants.index', $variant->product_id) }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Variant</button>
                </div>
            </form>
        </div>
    </div>
@endsection
