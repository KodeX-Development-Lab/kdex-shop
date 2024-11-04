<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createBrandRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_mm' => 'required|unique:brands,name_mm',
            'name_en' => 'required|unique:brands,name_en'
        ];
    }
}
