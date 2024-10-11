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
            'userId'    => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'clientId' => [
                'required',
                'integer',
                'exists:clients,id',
            ],
            'serviceId' => [
                'required',
                'integer',
                'exists:services,id',
            ],
            'date'       => ['required', 'date'],
            'hours'      => ['required', 'numeric'],
        ];
    }
}
