@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">Edit Attribute</div>
                <div class="card-body">
                    <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ $attribute->name }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select">
                                <option value="text" {{ $attribute->type == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="number" {{ $attribute->type == 'number' ? 'selected' : '' }}>Number</option>
                                <option value="color" {{ $attribute->type == 'color' ? 'selected' : '' }}>Color</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Attribute</button>
                    </form>
                </div>
            </div>
            <a href="{{ route('attributes.index') }}" class="btn btn-outline-secondary w-100">&larr; Back to List</a>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Manage Values for: <strong>{{ $attribute->name }}</strong>
                </div>
                <div class="card-body">

                    <form action="{{ route('attributes.values.store', $attribute->id) }}" method="POST" class="row g-2 mb-4 align-items-end">
                        @csrf
                        <div class="col-auto flex-grow-1">
                            <label class="form-label small text-muted">Add New Value</label>
                            <input type="text" name="value" class="form-control" placeholder="e.g. Red or XL" required>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success">+ Add</button>
                        </div>
                    </form>

                    <hr>

                    <h6 class="text-muted mb-3">Existing Values</h6>

                    @if($attribute->values->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                <tr>
                                    <th>Value</th>
                                    <th class="text-end" style="width: 100px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($attribute->values as $val)
                                    <tr>
                                        <td>{{ $val->value }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('attributes.values.destroy', $val->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-outline-danger btn-sm" onclick="return confirm('Delete this value?')">x</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning">No values added yet.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
