<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // DAFTAR PESANAN
    public function index()
    {
        $orders = Order::with(['user', 'payment'])->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // DETAIL PESANAN & UPDATE STATUS
    public function show(Order $order)
    {
        // Load relasi user, alamat, item (beserta produknya), payment, shipping
        $order->load(['user', 'address', 'items.variant.product', 'payment', 'shipping']);

        return view('orders.show', compact('order'));
    }

    // UPDATE STATUS (Hanya Update Status Order & Payment)
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,completed,cancelled',
            'payment_status' => 'required|in:pending,success,failed',
            'tracking_number' => 'nullable|string'
        ]);

        // Update Status Order
        $order->update(['status' => $request->status]);

        // Update Status Pembayaran (Jika ada datanya)
        if ($order->payment) {
            $order->payment->update(['status' => $request->payment_status]);
        }

        // Update Resi Pengiriman (Jika status shipped)
        if ($request->filled('tracking_number') && $order->shipping) {
            $order->shipping->update(['tracking_number' => $request->tracking_number]);
        }

        return redirect()->route('orders.show', $order->id)->with('success', 'Order status updated!');
    }

    // HAPUS PESANAN
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
    }
}
