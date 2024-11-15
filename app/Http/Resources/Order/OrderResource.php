<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'paymentType' => $this->paymentType,
            'products' => ProductResource::collection($this->products()),
            'paymentLink' => route('order.pay', ['payment' => $this->paymentType->id, 'order' => $this->id])
        ];
    }
}
