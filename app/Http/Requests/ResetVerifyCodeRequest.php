<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetVerifyCodeRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email', 'exists:unverified_users,email']
        ];
    }
}
