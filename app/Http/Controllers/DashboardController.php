<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung data untuk widget dashboard
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCustomers = User::whereHas('role', fn($q) => $q->where('name', 'Customer'))->count();

        return view('dashboard', compact('totalProducts', 'totalOrders', 'totalCustomers'));
    }
}
