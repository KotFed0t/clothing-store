<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackNotification;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class MainController extends Controller
{
    public function index()
    {
        $products = Product::get();
        return view('index', compact('products'));
    }

    public function categories()
    {
        $categories = Category::get();
        return view('categories', compact('categories'));
    }

    public function category($code)
    {
        $category = Category::where('code', $code)->first();
        return view('category', ['category' => $category]);
    }

    public function product($category, $product = null)
    {
        //$product = Product::where('code', $product)->first();
        return view('product', compact('product'));
    }

    public function showOrders()
    {
        $orders = auth()->user()->orders;
        return view('ordersHistory.orders', compact('orders'));
    }

    public function showOrderDetails($orderId)
    {
        $order = Order::findOrFail($orderId);
        $products = $order->products;
        return view('admin.orderDetails', compact('order', 'products'));
    }

    public function showFeedback()
    {
        return view('feedback.form');
    }

    public function saveFeedback(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:50'],
            'email' => ['required', 'email', 'string'],
            'phone' => ['required', 'regex:/(\+7|8)[\s(]*\d{3}[)\s]*\d{3}[\s-]?\d{2}[\s-]?\d{2}/'],
            'text' => ['required', 'string', 'min:2', 'max:800']
        ]);

        $data['status'] = 'new';

        $ticket = Ticket::create($data);

        if ($ticket) {
            Mail::to($data['email'])->send(new FeedbackNotification($ticket->id, $data['name']));
            session()->flash('success', 'Ваш отзыв успешно отправлен');
        }

        return redirect()->route('index');
    }

}
