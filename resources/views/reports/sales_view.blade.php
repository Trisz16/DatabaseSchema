@extends('layout.app')

@section('content')
    <div class="mb-3">
        <h3><i class="bi bi-graph-up-arrow"></i> Monthly Sales Report</h3>
        <p class="text-muted">Rekapitulasi Omzet Penjualan per Bulan</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="bg-success text-white">
                        <tr>
                            <th>Month (Period)</th>
                            <th class="text-center">Total Orders</th>
                            <th class="text-center">Successful</th>
                            <th class="text-center">Cancelled</th>
                            <th class="text-end">Total Revenue (Omzet)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $row)
                            <tr>
                                <td class="fw-bold">{{ \Carbon\Carbon::parse($row->month)->format('F Y') }}</td>
                                <td class="text-center">{{ $row->total_orders }}</td>
                                <td class="text-center text-success">{{ $row->completed_orders }}</td>
                                <td class="text-center text-danger">{{ $row->cancelled_orders }}</td>
                                <td class="text-end fw-bold fs-5">Rp {{ number_format($row->total_revenue) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">No sales data yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
