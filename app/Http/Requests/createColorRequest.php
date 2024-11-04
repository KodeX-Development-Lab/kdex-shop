<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
           'name_mm' => 'required|unique:colors,name_mm',
           'name_en' => 'required|unique:colors,name_en'
        ];
    }
}
