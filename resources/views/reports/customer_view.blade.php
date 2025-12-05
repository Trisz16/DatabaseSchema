@extends('layout.app')

@section('content')
    <div class="mb-3">
        <h3><i class="bi bi-people-fill"></i> Top Customers</h3>
        <p class="text-muted">Daftar 20 Pelanggan dengan total belanja tertinggi (Loyal Customer)</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="bg-warning text-dark">
                <tr>
                    <th>Rank</th>
                    <th>Customer Name</th>
                    <th>Contact Info</th>
                    <th class="text-center">Total Orders</th>
                    <th class="text-end">Total Spent</th>
                    <th>Last Active</th>
                </tr>
                </thead>
                <tbody>
                @forelse($data as $index => $row)
                    <tr>
                        <td class="fw-bold text-center">#{{ $index + 1 }}</td>
                        <td>
                            <span class="fw-bold">{{ $row->name }}</span>
                        </td>
                        <td>
                            <small>{{ $row->email }}</small><br>
                            <small class="text-muted">{{ $row->phone ?? '-' }}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary rounded-pill">{{ $row->total_transaction_count }}x</span>
                        </td>
                        <td class="text-end fw-bold text-primary">Rp {{ number_format($row->total_spent) }}</td>
                        <td class="small">{{ \Carbon\Carbon::parse($row->last_order_date)->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No transaction data yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
