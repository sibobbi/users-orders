<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'sort' => [Rule::in(['asc', 'desc'])],
        ];
    }
}
