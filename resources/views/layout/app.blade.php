<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel E-Commerce Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; box-shadow: 0 0 10px rgba(0,0,0,0.1); background: white; }
        .nav-link { color: #333; font-weight: 500; }
        .nav-link:hover, .nav-link.active { background-color: #e9ecef; color: #0d6efd; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-3 sidebar">
            <h4 class="text-primary fw-bold mb-4">MyToko Admin</h4>
            <div class="nav flex-column nav-pills">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Dashboard</a>
                <hr>
                <small class="text-muted text-uppercase mb-2">Master Data</small>
                <a href="{{ route('brands.index') }}" class="nav-link {{ request()->is('brands*') ? 'active' : '' }}">Brands</a>
                <a href="{{ route('categories.index') }}" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">Categories</a>
                <a href="{{ route('attributes.index') }}" class="nav-link {{ request()->is('attributes*') ? 'active' : '' }}">Attributes</a>

                <hr>
                <small class="text-muted text-uppercase mb-2">Inventory</small>
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">Products</a>
                <a href="{{ route('variants.all') }}" class="nav-link {{ request()->routeIs('variants.all') ? 'active' : '' }}">
                    Product Variants
                </a>

                <hr>
                <small class="text-muted text-uppercase mb-2">Transactions</small>
                <a href="{{ route('orders.index') }}" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">Orders</a>
                <a href="{{ route('customers.index') }}" class="nav-link {{ request()->is('customers*') ? 'active' : '' }}">Customers</a>

                <hr>
                <small class="text-muted text-uppercase mb-2">Database Views (Reports)</small>

                <a href="{{ route('reports.products') }}" class="nav-link {{ request()->routeIs('reports.products') ? 'active' : '' }}">
                    📊 Product Stock View
                </a>
                <a href="{{ route('reports.orders') }}" class="nav-link {{ request()->routeIs('reports.orders') ? 'active' : '' }}">
                    📑 Order Recap View
                </a>

                <a href="{{ route('reports.sales') }}" class="nav-link {{ request()->routeIs('reports.sales') ? 'active' : '' }}">
                    💰 Monthly Sales
                </a>
                <a href="{{ route('reports.top_customers') }}" class="nav-link {{ request()->routeIs('reports.top_customers') ? 'active' : '' }}">
                    🏆 Top Customers
                </a>
            </div>
        </div>

        <div class="col-md-10 p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
