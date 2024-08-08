<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'            => [
                'required',
                'email',
                Rule::unique('users')
            ],
            'name'             => [
                'required',
                'string',
            ],
            'password'         => [
                'required',
                Password::min(8),
            ],
            'confirm_password' => [
                'required',
                'same:password'
            ],
            'roles'            => [
                'array',
            ],
            'roles.*'          => [
                'numeric',
                'exists:roles,id'
            ],
            'companies'        => [
                'array',
            ],
            'companies.*'      => [
                'numeric',
                'exists:companies,id'
            ],
            'services'         => [
                'array',
            ],
            'services.*'       => [
                'numeric',
                'exists:services,id'
            ],
            'servicesDetails'  => [
                'array',
            ],
            'servicesDetails.*.service_id' => [
                'required',
                'numeric',
                'exists:services,id'
            ],
            'servicesDetails.*.cost_per_hour' => [
                'required',
                'numeric',
            ],
        ];
    }
}
