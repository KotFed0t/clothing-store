<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;
use YooKassa\Client;

class PaymentService
{
    private function getClient(): Client
    {
        $client = new Client();
        $client->setAuth(config('services.yookassa.shop_id'), config('services.yookassa.secret_key'));
        return $client;
    }

    private function createTransaction(Order $order, $userId)
    {
        return Transaction::create([
            'user_id' => $userId,
            'order_id' => $order->id,
            'price' => $order->getFullPrice(),
            'description' => 'Оплата заказа'
        ]);
    }

    public function createPayment(Order $order, $userId)
    {
        $client = $this->getClient();
        $transaction = $this->createTransaction($order, $userId);

        if ($transaction) {
            $payment = $client->createPayment(
                array(
                    'amount' => array(
                        'value' => $order->getFullPrice(),
                        'currency' => 'RUB',
                    ),
                    'confirmation' => array(
                        'type' => 'redirect',
                        'return_url' => route('orders'),
                    ),
                    'capture' => true,
                    'metadata' => [
                        'transaction_id' => $transaction->id
                ],
                    'description' => 'Оплата заказа',
                ),
                uniqid('', true)
            );

            return $payment->getConfirmation()->getConfirmationUrl();
        }
    }

    public function callback()
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);
        \Log::info($source);
    }



}
