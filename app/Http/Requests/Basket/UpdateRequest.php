<?php

namespace App\Http\Requests\Basket;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => ['required','integer',Rule::exists(Product::class, 'id')],
            'quantity' => ['required', 'integer', 'min:0']
        ];
    }
}
