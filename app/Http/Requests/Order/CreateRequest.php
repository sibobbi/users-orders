<?php

namespace App\Http\Requests\Order;

use App\Models\Basket;
use App\Models\Payment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'basket_id' => ['required', Rule::exists(Basket::class, 'id')],
            'payment_type' => ['required', Rule::exists(Payment::class, 'id')],
        ];
    }
}
