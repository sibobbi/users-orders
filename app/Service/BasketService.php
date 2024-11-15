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

            $basket->products()->updateExistingPivot($product_basket->id, [
                'quantity' => $quantity,
                'price' => $product->price,
                'sum' => $product->price * $quantity
            ]);
            $product_basket->save();
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
