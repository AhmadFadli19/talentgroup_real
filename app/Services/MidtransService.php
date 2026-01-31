<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction($orderId, $amount, $customerDetails)
    {
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $amount,
        ];

        $itemDetails = [
            [
                'id' => $orderId,
                'price' => $amount,
                'quantity' => 1,
                'name' => 'Top Up Saldo'
            ]
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        return Snap::createTransaction($params);
    }

    public function handleNotification()
    {
        $notification = new Notification();
        
        return [
            'order_id' => $notification->order_id,
            'status_code' => $notification->status_code,
            'gross_amount' => $notification->gross_amount,
            'transaction_status' => $notification->transaction_status,
            'fraud_status' => $notification->fraud_status ?? null,
            'payment_type' => $notification->payment_type,
            'transaction_time' => $notification->transaction_time,
            'signature_key' => $notification->signature_key,
        ];
    }
}