<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackNotification;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Property;
use App\Models\Ticket;
use App\Services\CaptchaService;
use App\Services\FilterProductsService;
use App\Services\GoogleAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class MainController extends Controller
{
    public function index()
    {
        $products = Product::get();
        $categories = Category::get();
        return view('index', compact('products', 'categories'));
    }

    public function categories()
    {
        $categories = Category::get();
        return view('categories', compact('categories'));
    }

    public function categoryGender(Request $request, $gender)
    {
       $products = FilterProductsService::filter($request, $gender);

        $properties = Property::get();
        return view('category', compact('products', 'gender', 'properties'));
    }

    public function category(Request $request, $gender, $code)
    {
        $category = Category::where('code', $code)->first();
        $products = FilterProductsService::filter($request, $gender, $category->id);
        $properties = Property::get();
        return view('category', ['category' => $category, 'products' => $products, 'properties' => $properties]);
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
        return view('ordersHistory.orderDetails', compact('order', 'products'));
    }

    public function showFeedback()
    {
        $captcha = new CaptchaService();
        $captchaImg = $captcha->generateCaptcha();
        return view('feedback.form', ['captchaImg' => $captchaImg]);
    }

    public function saveFeedback(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:50'],
            'email' => ['required', 'email', 'string'],
            'phone' => ['required', 'regex:/(\+7|8)[\s(]*\d{3}[)\s]*\d{3}[\s-]?\d{2}[\s-]?\d{2}/'],
            'text' => ['required', 'string', 'min:2', 'max:800'],
            'captcha' => ['required']
        ]);

        if (session('captcha') !== $data['captcha']) {
            return redirect()->route('showFeedback')->withInput()->withErrors(['captcha' => 'Капча введена неверно']);
        }

        $data['status'] = 'new';

        $ticket = Ticket::create($data);

        if ($ticket) {
            Mail::to($data['email'])->send(new FeedbackNotification($ticket->id, $data['name']));
            session()->flash('success', 'Ваш отзыв успешно отправлен');
        }

        session()->forget(['captcha']);

        return redirect()->route('index');
    }

    public function search(Request $request)
    {
        $data = $request->validate(['search' => ['required', 'string', 'max:50']]);
        $search = $data['search'];
        $products = Product::where('name', 'ilike', '%' . $search . '%')
            ->orWhere('description', 'ilike', '%' . $search . '%')
            ->get();
        return view('index', compact(['products', 'search']));
    }

}
