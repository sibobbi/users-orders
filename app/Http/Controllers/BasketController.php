<?php

namespace App\Http\Controllers;

use App\Http\Requests\Basket\UpdateRequest;
use App\Http\Resources\Basket\BasketResource;
use App\Models\Product;
use App\Service\BasketService;


class BasketController extends Controller
{
    public function update(UpdateRequest $request, BasketService $service)
    {
        $product = Product::query()->find($request->validated('product_id'));
        $basket = $request->user()->basket()->firstOrCreate();
        $quantity = $request->validated('quantity');

        return BasketResource::make($service->update($product, $basket, $quantity));
    }
}
