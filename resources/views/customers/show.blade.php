@extends('layout.app')

@section('content')
    <div class="mb-3">
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">&larr; Back</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white text-center">
                    <h5>{{ $customer->name }}</h5>
                    <small>{{ $customer->email }}</small>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Phone:</strong> {{ $customer->profile->phone ?? '-' }}</li>
                        <li class="list-group-item"><strong>Gender:</strong> {{ $customer->profile->gender ?? '-' }}</li>
                        <li class="list-group-item"><strong>Joined:</strong> {{ $customer->created_at->format('d M Y') }}</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Saved Addresses</div>
                <ul class="list-group list-group-flush">
                    @forelse($customer->addresses as $addr)
                        <li class="list-group-item">
                            <strong>{{ $addr->recipient_name }}</strong>
                            @if($addr->is_primary) <span class="badge bg-success">Primary</span> @endif
                            <br>
                            <small>{{ $addr->address_line }}, {{ $addr->city }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No address saved.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Order History</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($customer->orders as $order)
                            <tr>
                                <td><a href="{{ route('orders.show', $order->id) }}">#{{ substr($order->id, 0, 8) }}</a></td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>{{ number_format($order->total_price) }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No orders yet.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
