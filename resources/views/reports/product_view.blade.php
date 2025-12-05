@extends('layout.app')

@section('content')
    <div class="mb-3">
        <h3><i class="bi bi-table"></i> Product Summary View</h3>
        <p class="text-muted">Hasil Join Table: Products + Brands + Categories + Variants (Sum Stock)</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="bg-primary text-white">
                <tr>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Total Variants</th>
                    <th>Total Stock (All Variants)</th>
                    <th>Start Price</th>
                </tr>
                </thead>
                <tbody>
                @forelse($data as $row)
                    <tr>
                        <td class="fw-bold">{{ $row->product_name }}</td>
                        <td>{{ $row->brand_name }}</td>
                        <td><span class="badge bg-info text-dark">{{ $row->category_name }}</span></td>
                        <td class="text-center">{{ $row->variant_count }}</td>
                        <td class="text-center">
                            @if($row->total_stock == 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @else
                                <span class="badge bg-success">{{ $row->total_stock }} pcs</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($row->lowest_price) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No data available</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
