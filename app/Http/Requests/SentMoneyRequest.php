<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SentMoneyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'to_phone' => 'required',
            'amount' => 'required'
        ];
    }
}
