<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(auth()->user()->id)
            ],
            'name' => [
                'required',
                'string',
            ],
            'country' =>[
                'nullable',
                'exists:countries,id',
                'required_with:state'
            ],
            'city' =>[
                'nullable',
                'exists:cities,id',
                'required_with:country,state'
            ],
            'state' =>[
                'nullable',
                'string',
            ]
        ];
    }
}
