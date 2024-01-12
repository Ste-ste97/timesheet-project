<?php

namespace App\Http\Requests\Translaton;

use Illuminate\Foundation\Http\FormRequest;

class StoreTranslationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key'      => 'required|string',
            'value'    => 'required|string',
            'language' => 'required|string|in:en,gr',
        ];
    }
}