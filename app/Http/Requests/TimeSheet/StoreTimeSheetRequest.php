<?php

namespace App\Http\Requests\TimeSheet;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimeSheetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'hours' => ['required', 'numeric'],
        ];
    }
}
