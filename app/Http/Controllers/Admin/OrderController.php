<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'paymentMethod', 'shippingAddress'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'paymentMethod', 'shippingAddress', 'orderItems.productVariant.product'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'order_status' => 'required|string|in:pending,paid,processing,shipped,completed,cancelled,failed',
        ]);

        $order->order_status = $request->order_status;
        $order->save();

        return redirect()->route('admin.orders.show', $order->order_id)
            ->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }
}
