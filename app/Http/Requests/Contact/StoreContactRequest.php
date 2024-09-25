<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'      => 'required|string|max:255',
            'mobile_phone'   => 'required|string|max:20',
            'landline_phone' => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
            'fax'            => 'nullable|string|max:20',
            'email'          => [
                'required',
                'email',
                Rule::unique('contacts')
            ],
            'postal_code'    => 'nullable|string|max:10',
        ];
    }
}
