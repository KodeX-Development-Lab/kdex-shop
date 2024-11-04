<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateTaskDelivery extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'user_id' => 'required',
            'description' => 'required',
            'priority' => 'required',
            'status' => 'required',
            'product_id' => 'required',
            'start_date' => 'required',
            'deadline' => 'required',
            'customer_address' => 'required',
            'phone' => 'required'
        ];
    }
}
