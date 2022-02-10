<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users')
            ],
            'name' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                Password::min(8),
            ],
            'confirm_password' => [
                'required',
                'same:password'
            ],
            'roles' => [
                'array',
            ],
            'roles.*' => [
                'numeric',
                'exists:roles,id'
            ],
        ];
    }
}
