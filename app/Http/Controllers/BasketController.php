<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function basket(Request $request)
    {
        $orderId = session('orderId');
        $order = null;
        if (!is_null($orderId)) {
            $order = Order::findOrFail($orderId);
        }
        return view('basket', compact('order'));

    }

    //только авторизованные пользователи
    public function basketPlace()
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            return redirect()->route('index');
        }
        $order = Order::find($orderId);
        return view('basketOrder', compact('order'));
    }

    //только авторизованные пользователи
    public function basketConfirm(Request $request)
    {
        $data = $request->validate([
            'country' => ['required', 'string', 'min:2', 'max:50'],
            'city' => ['required', 'string', 'min:2', 'max:50'],
            'address' => ['required', 'string', 'min:2', 'max:100'],
            'postal_code' => ['required', 'digits:6']
        ]);

        $user = auth()->user();
        $data['user_id'] = $user->id;

        $orderId = session('orderId');
        if (is_null($orderId)) {
            return redirect()->route('index');
        }

        $order = Order::find($orderId);

        $payment = new PaymentService();
        $link = $payment->createPayment($order, $user->id);

        //можно добавить новый статус 'ожидает оплаты'
        $order->update($data);
        session()->forget('orderId');
        session()->flash('success', 'Ваш заказ принят в обработку!');

        return redirect($link);
    }

    public function paymentCallback(Request $request)
    {
        $payment = new PaymentService();
        $payment->callback($request->ip());
    }

    public function basketAdd($productId)
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            $order = Order::create();
            session(['orderId' => $order->id]);
        } else {
            $order = Order::find($orderId);
        }

        if ($order->products->contains($productId)){
            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
            $pivotRow->count++;
            $pivotRow->update();
        } else {
            $order->products()->attach($productId);
        }

        $product = Product::find($productId);
        session()->flash('success', "Товар \"$product->name\" добавлен в корзину");
        return redirect()->route('basket');
    }

    public function basketRemove($productId)
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            return redirect()->route('basket');
        }
        $order = Order::find($orderId);

        if ($order->products->contains($productId)){
            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
            if ($pivotRow->count < 2) {
                $order->products()->detach($productId);
            } else {
                $pivotRow->count--;
                $pivotRow->update();
            }
        }

        $product = Product::find($productId);
        session()->flash('warning', "Товар \"$product->name\" удален из корзины");

        return redirect()->route('basket');
    }
}
