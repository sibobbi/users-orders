<?php

namespace App\Service;

use App\Models\Basket;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;

class OrderService
{
    public function create(Basket $basket, Payment $payment)
    {
        $order = Order::query()->make();
        $order->paymentType()->associate($payment);
        $order->products()->sync(
            $basket->products->mapWithKeys(function (Product $product) {
                return [
                    $product->id => [
                        'price' => $product->pivot->price,
                        'sum' => $product->pivot->sum,
                        'quantity' => $product->pivot->quantity,
                    ]
                ];
            })->toArray()
        );
        $order->save();

        return $order;
    }
}
