<?php

namespace App\Http\Requests\TimeSheet;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimeSheetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hours' => ['required', 'numeric'],
        ];
    }
}
