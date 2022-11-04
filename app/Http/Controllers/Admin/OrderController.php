<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EmailOrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function showOrders(Request $request)
    {
        if ($request->has('status_id')) {
            if ($request->get('status_id') == 0) {
                $orders = Order::where('status', '!=',0)->orderBy('created_at', 'desc')->get();
            } else {
                $orders = Order::where('status', $request->get('status_id'))->orderBy('created_at', 'desc')->get();
            }
        } else {
            $orders = Order::where('status', '!=',0)->orderBy('created_at', 'desc')->get();
        }
        return view('admin.orders', compact('orders'));
    }

    public function showOrderDetails(Request $request, $orderId) {
        $order = Order::find($orderId);
        $products = $order->products;
        $userEmail = User::find($order->user_id)->email;

        if ($request->has('status_id')) {
            $order->status = $request->get('status_id');
            $order->save();
            Mail::to($userEmail)->send(new EmailOrderStatus($order));
            session()->flash('success', 'Статус заказа успешно обновлен');
        }
        return view('admin.orderDetails', compact('order', 'products'));
    }


}
