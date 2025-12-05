@extends('layout.app')

@section('content')
    <h2 class="mb-4">Dashboard Overview</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text fs-2">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text fs-2">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Customers</h5>
                    <p class="card-text fs-2">{{ $totalCustomers }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
