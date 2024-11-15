<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'email' => ['required','email', Rule::exists(User::class, 'email')],
            'password' => ['required', 'string', 'min:1'],
        ];
    }
}
