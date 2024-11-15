<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Product\ProductResource as ShowProductResource;
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'price' => $this->pivot->price / 100,
            'quantity' => $this->pivot->quantity,
            'sum' => $this->pivot->sum / 100,
            'product' =>  ShowProductResource::make($this),
        ];
    }
}
