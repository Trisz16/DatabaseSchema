@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Customer List</h2>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">+ Add Customer</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td class="fw-bold">{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->profile->phone ?? '-' }}</td>
                        <td>{{ $customer->profile->gender ?? '-' }}</td>
                        <td>{{ $customer->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-info text-white">Detail</a>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete customer?')">Del</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $customers->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
