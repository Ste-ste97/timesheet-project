<?php

namespace App\Http\Requests\Profile;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password'     => [
                'required',
                'current_password',
            ],
            'new_password'         => [
                'required',
                Password::min(8),
            ],
            'confirm_new_password' => [
                'required',
                'same:new_password'
            ]
        ];
    }
}
