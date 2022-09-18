<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use YooKassa\Client;
use YooKassa\Model\NotificationEventType;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationCanceled;

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
                        'transaction_id' => $transaction->id,
                        'order_id' => $order->id
                    ],
                    'description' => 'Оплата заказа',
                ),
                uniqid('', true)
            );

            return $payment->getConfirmation()->getConfirmationUrl();
        }
    }

    public function callback($requestIp)
    {
        $yookassaCidrs = [
            '185.71.76.0/27',
            '185.71.77.0/27',
            '77.75.153.0/25',
            '77.75.156.11',
            '77.75.156.35',
            '77.75.154.128/25'
        ];

        try {
            $eligibleIp = false;
            foreach ($yookassaCidrs as $cidr) {
                if ($this->ip_in_range($requestIp, $cidr)) {
                    $eligibleIp = true;
                    break;
                }
            }

            if ($eligibleIp === false) {
                throw new Exception("not eligible ip: $requestIp");
            }

            $source = file_get_contents('php://input');
            $requestBody = json_decode($source, true);
            Log::info($requestIp);
            Log::info($source);


            $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
                ? new NotificationSucceeded($requestBody)
                : new NotificationCanceled($requestBody);

            $payment = $notification->getObject();
            if ($payment->status === 'succeeded') {
                if ($payment->paid === true) {
                    $metadata = $payment->metadata;

                    $transaction_id = (int)$metadata->transaction_id;
                    $transaction = Transaction::find($transaction_id);
                    $transaction->payment_id = $payment->id;
                    $transaction->rrn = $payment->authorization_details->rrn;
                    $transaction->status = 'CONFIRMED';
                    $transaction->save();

                    $order_id = (int)$metadata->order_id;
                    $order = Order::find($order_id);
                    $order->status = 1;
                    $order->save();
                }
            } elseif ($payment->status === 'canceled') {
                $metadata = $payment->metadata;
                if (isset($metadata->transaction_id)) {
                    $transaction_id = (int)$metadata->transaction_id;
                    $transaction = Transaction::find($transaction_id);
                    $transaction->payment_id = $payment->id;
                    $transaction->status = 'CANCELED';
                    $transaction->save();

                    //добавить статус отмены и подставить сюда потом
//                    $order_id = (int)$metadata->order_id;
//                    $order = Order::find($order_id);
//                    $order->status = 1;
//                    $order->save();
                }
            }

        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function ip_in_range($ip, $range)
    {
        if (strpos($range, '/') == false) {
            $range .= '/32';
        }
        // $range is in IP/CIDR format eg 127.0.0.1/24
        list($range, $netmask) = explode('/', $range, 2);
        $range_decimal = ip2long($range);
        $ip_decimal = ip2long($ip);
        $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
        $netmask_decimal = ~$wildcard_decimal;
        return (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
    }


}
