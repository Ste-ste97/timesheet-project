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
                'numeric',
                'exists:services,id'
            ],
            'servicesDetails.*.cost_per_hour' => [
                'required',
                'numeric',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'servicesDetails.*.cost_per_hour.required' => 'The cost per hour is required.',
            'servicesDetails.*.cost_per_hour.numeric'  => 'The cost per hour must be a numeric value.',
        ];
    }
}
