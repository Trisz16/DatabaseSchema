@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Attributes</h2>
        <a href="{{ route('attributes.create') }}" class="btn btn-primary">+ Add Attribute</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Total Values</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($attributes as $attr)
                    <tr>
                        <td class="fw-bold">{{ $attr->name }}</td>
                        <td><span class="badge bg-secondary">{{ strtoupper($attr->type) }}</span></td>
                        <td>{{ $attr->values_count }} items</td>
                        <td>
                            <a href="{{ route('attributes.edit', $attr->id) }}" class="btn btn-sm btn-warning">Manage Values</a>
                            <form action="{{ route('attributes.destroy', $attr->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete attribute?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $attributes->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
