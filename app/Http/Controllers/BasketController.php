<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Property;
use App\Services\MailAuthService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{
    public function basket(Request $request)
    {
        $orderId = session('orderId');
        $order = null;
        if (!is_null($orderId)) {
            $order = Order::findOrFail($orderId);
        }
        $propertyIdBrand = Property::where('name', 'бренд')->first()->id;
        return view('basket', compact('order', 'propertyIdBrand'));

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
        $order->update($data);

        $mailAuth = new MailAuthService();
        $mailAuth->setCodeAndSendToUser($user, 'order', $order);

        session(['fromOrder' => true]);

        return redirect()->route('orderShow2Fa');
    }

    public function paymentCallback(Request $request)
    {
        $payment = new PaymentService();
        $payment->callback($request->ip());
    }

    public function basketAdd(Request $request, $productId, $sizeId = null)
    {
        if ($sizeId == null) {
            $sizeId = $request->get('size_id');
        }

        $orderId = session('orderId');
        if (is_null($orderId)) {
            $order = Order::create();
            session(['orderId' => $order->id]);
            $orderId = $order->id;
        }

        $row = DB::table('order_product')->where('order_id', $orderId)->where('product_id', $productId)->where('size_id', $sizeId)->select()->first();
        if ($row !== null) {
            DB::table('order_product')->where('order_id', $orderId)->where('product_id', $productId)->where('size_id', $sizeId)->update(['count' => $row->count + 1]);
        } else {
            DB::table('order_product')->insert(['order_id' => $orderId, 'product_id' => $productId, 'count' => 1, 'size_id' => $sizeId]);
        }

        session()->flash('success', "Товар добавлен в корзину");
        return redirect()->back();
    }

    public function basketRemove($productId, $sizeId)
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            return redirect()->route('basket');
        }

        $row = DB::table('order_product')->where('order_id', $orderId)->where('product_id', $productId)->where('size_id', $sizeId)->select()->first();
        if ($row !== null) {
            if ($row->count < 2) {
                DB::table('order_product')->where('order_id', $orderId)->where('product_id', $productId)->where('size_id', $sizeId)->delete();
            } else {
                DB::table('order_product')->where('order_id', $orderId)->where('product_id', $productId)->where('size_id', $sizeId)->update(['count' => $row->count - 1]);
            }
        }

        session()->flash('warning', "Товар удален из корзины");

        return redirect()->route('basket');
    }
}
