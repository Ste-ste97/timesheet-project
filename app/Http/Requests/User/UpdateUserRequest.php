<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
                Rule::unique('users')->ignore($this->id)
            ],
            'name'             => [
                'required',
                'string',
            ],
            'password'         => [
                'nullable',
                Password::min(8),
            ],
            'confirm_password' => [
                'required_with:password',
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
