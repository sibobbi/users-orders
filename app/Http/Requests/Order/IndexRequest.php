<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'sort' => [Rule::in(['asc', 'desc'])],
            'filter' => [Rule::in(OrderStatus::cases())],
        ];
    }
}
