@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Order History</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="small">{{ substr($order->id, 0, 8) }}...</td>
                        <td class="fw-bold">{{ $order->user->name }}</td>
                        <td>Rp {{ number_format($order->total_price) }}</td>
                        <td>
                            @if($order->status == 'completed') <span class="badge bg-success">Completed</span>
                            @elseif($order->status == 'pending') <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($order->status == 'cancelled') <span class="badge bg-danger">Cancelled</span>
                            @else <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $order->payment->method ?? '-' }}</span>
                        </td>
                        <td class="small">{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">No orders found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
