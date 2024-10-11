<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'is_private'     => 'required|boolean',
            'mobile_phone'   => 'required|string|max:20',
            'landline_phone' => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
            'fax'            => 'nullable|string|max:20',
            'email'          => [
                'required',
                'email',
                Rule::unique('clients')
            ],
            'postal_code'    => 'nullable|string|max:10',
            'users'          => [
                'array',
            ],
            'users.*'        => [
                'numeric',
                'exists:users,id'
            ],
        ];
    }
}
