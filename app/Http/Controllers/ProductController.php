<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\IndexRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(IndexRequest $request)
    {
        $sort = $request->validated('sort') ?? false;
        $productQuery = Product::query();

        if ($sort) {
            $productQuery->orderBy('price',$sort);
        }

        return ProductResource::collection($productQuery->get());
    }

    public function show(Product $product)
    {
        return ProductResource::make($product);
    }
}
