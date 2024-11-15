<?php

namespace App\Service;

use App\Enums\OrderStatus;
use App\Models\Basket;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;

class OrderService
{
    public function create(Basket $basket, Payment $payment, User $user)
    {
        $order = Order::query()->make();
        $order->paymentType()->associate($payment);
        $order->user()->associate($user);

        $products = $basket->products->mapWithKeys(function (Product $product) {
            return [
                $product->id => [
                    'price' => $product->pivot->price,
                    'sum' => $product->pivot->sum,
                    'quantity' => $product->pivot->quantity,
                ]
            ];
        });

        $sumOrder = $products->sum('sum');
        $order->sum = $sumOrder;
        $order->status = OrderStatus::FOR_PAYMENT;
        $order->save();

        $order->products()->sync(
            $products->toArray()
        );


        return $order;
    }
}
