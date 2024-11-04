<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreate extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' =>'required|unique:categories,name',
            'image' => 'required|mimes:png,jpg,webp,jpeg'
        ];
    }
}
