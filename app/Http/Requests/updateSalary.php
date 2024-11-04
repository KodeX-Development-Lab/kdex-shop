<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateSalary extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required',
           'year' => 'required',
           'month' => 'required',
           'amount' => 'required'
        ];
    }
}
