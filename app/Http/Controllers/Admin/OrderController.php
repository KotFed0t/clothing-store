<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showOrders()
    {
        $orders = Order::where('status', 1)->orderBy('updated_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    public function showOrderDetails($orderId) {
        $order = Order::find($orderId);
        $products = $order->products;
        return view('admin.orderDetails', compact('order', 'products'));

    }
}
