<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'exists:unverified_users,email', 'email'],
            'email_verify_code' => ['required'],
        ];
    }
}
