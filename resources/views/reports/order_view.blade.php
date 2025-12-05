@extends('layout.app')

@section('content')
    <div class="mb-3">
        <h3><i class="bi bi-cart-check"></i> Order Recap View</h3>
        <p class="text-muted">Hasil Join Table: Orders + Users + Payments + Shippings</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Customer Info</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Shipping</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $row)
                        <tr>
                            <td><small>{{ substr($row->order_id, 0, 8) }}...</small></td>
                            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</td>
                            <td>
                                <strong>{{ $row->customer_name }}</strong><br>
                                <small class="text-muted">{{ $row->customer_email }}</small>
                            </td>
                            <td class="fw-bold">Rp {{ number_format($row->total_price) }}</td>
                            <td>
                            <span class="badge bg-{{ $row->order_status == 'completed' ? 'success' : ($row->order_status == 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($row->order_status) }}
                            </span>
                            </td>
                            <td>
                                <small>
                                    Method: {{ $row->payment_method ?? '-' }}<br>
                                    Status: <strong>{{ ucfirst($row->payment_status ?? '-') }}</strong>
                                </small>
                            </td>
                            <td>
                                <small>
                                    {{ $row->courier ?? '-' }}<br>
                                    Resi: <code class="text-primary">{{ $row->tracking_number ?? 'N/A' }}</code>
                                </small>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No orders found</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
