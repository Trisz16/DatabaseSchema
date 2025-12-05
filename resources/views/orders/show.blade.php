@extends('layout.app')

@section('content')
    <div class="mb-3">
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">&larr; Back to Orders</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between">
                    <span>Order #{{ $order->id }}</span>
                    <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->variant->product->name ?? 'Unknown Product' }}</strong><br>
                                    <small class="text-muted">
                                        {{-- Loop Attributes (Manual Query utk tampilan simpel) --}}
                                        @foreach($item->variant->attributeValues as $val)
                                            {{ $val->attribute->name }}: {{ $val->value }} |
                                        @endforeach
                                    </small>
                                </td>
                                <td>{{ $item->variant->sku ?? '-' }}</td>
                                <td>{{ number_format($item->price_per_unit) }}</td>
                                <td>x {{ $item->quantity }}</td>
                                <td class="text-end">{{ number_format($item->subtotal) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Shipping Cost</td>
                            <td class="text-end">{{ number_format($order->shipping->cost ?? 0) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end fw-bold fs-5">Total</td>
                            <td class="text-end fw-bold fs-5">Rp {{ number_format($order->total_price) }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Customer Info</div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Name:</strong> {{ $order->user->name }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $order->user->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Shipping Address</div>
                        <div class="card-body">
                            <p class="mb-1"><strong>{{ $order->address->recipient_name }}</strong></p>
                            <p class="mb-1">{{ $order->address->address_line }}</p>
                            <p class="mb-1">{{ $order->address->city }}, {{ $order->address->postal_code }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">Manage Status</div>
                <div class="card-body">
                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Order Status</label>
                            <select name="status" class="form-select">
                                @foreach(['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $st)
                                    <option value="{{ $st }}" {{ $order->status == $st ? 'selected' : '' }}>
                                        {{ ucfirst($st) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select">
                                @foreach(['pending', 'success', 'failed'] as $pst)
                                    <option value="{{ $pst }}" {{ optional($order->payment)->status == $pst ? 'selected' : '' }}>
                                        {{ ucfirst($pst) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tracking Number (Resi)</label>
                            <input type="text" name="tracking_number" class="form-control"
                                   value="{{ $order->shipping->tracking_number ?? '' }}"
                                   placeholder="Input Resi JNE/DHL">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-2">Update Status</button>
                    </form>

                    <hr>

                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100"
                                onclick="return confirm('DANGER: Delete this order permanently?')">
                            Delete Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
