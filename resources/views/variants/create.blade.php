@extends('layout.app')

@section('content')
    <div class="card" style="max-width: 700px; margin: auto;">
        <div class="card-header bg-primary text-white">
            Add Variant for: <strong>{{ $product->name }}</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('products.variants.store', $product->id) }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">SKU (Code)</label>
                        <input type="text" name="sku" class="form-control" placeholder="e.g. TSHIRT-RED-XL" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" value="0" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Price (Final or Adjustment)</label>
                    <input type="number" name="price_adjustment" class="form-control" value="0" required>
                    <small class="text-muted">Masukkan harga jual varian ini.</small>
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
                                    <option value="{{ $val->id }}">{{ $val->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                    @if($attributes->isEmpty())
                        <div class="alert alert-warning">
                            No attributes found. Please create Attributes (Color, Size) first!
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('products.variants.index', $product->id) }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success">Save Variant</button>
                </div>
            </form>
        </div>
    </div>
@endsection
