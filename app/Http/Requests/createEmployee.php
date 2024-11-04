<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createEmployee extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pin_code' => 'required|unique:users,pin_code',
            'image'=> 'required',
            'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required|unique:users,phone',
            'nrc_number' => 'required|unique:users,nrc_number',
            'birthday' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'employee_id' => 'required|unique:users,employee_id,',
            'department_id' => 'required',
            'join_date' => 'required',
            'is_present' => 'required',
        ];
    }
}
