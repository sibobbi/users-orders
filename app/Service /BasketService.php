<?php

namespace App\Service;

use App\Models\Basket;
use App\Models\Product;

class BasketService
{
    public function update(Product $product, Basket $basket, int $quantity): Basket
    {
        $product_basket = $basket->products()->where('product_id',$product->id)->first();

        if ($product_basket) {
            if ($quantity === 0) {
                $basket->products()->detach($product->id);

                return $basket;
            }
            $product_basket->quantity = $quantity;
            $product_basket->price = $product->price;
            $product_basket->sum = $product->price * $quantity;
        } elseif ($quantity !== 0) {
            $basket->products()->attach($product->id, [
                'quantity' => $quantity,
                'price' => $product->price,
                'sum' => $product->price * $quantity
            ]);
        }

        return $basket;
    }

    public function clear(Basket $basket): void
    {
        $basket->products()->detach();
    }
}
