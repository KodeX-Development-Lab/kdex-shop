<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateEmployee extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('employee');
        return [
            'pin_code' => 'unique:users,pin_code,'.$id,
            'name' => 'required|unique:users,name,'.$id,
            'email' => 'required|unique:users,email,'.$id,
            'phone' => 'required|unique:users,phone,'.$id,
            'nrc_number' => 'required|unique:users,nrc_number,'.$id,
            'birthday' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'employee_id' => 'required|unique:users,employee_id,'.$id,
            'department_id' => 'required',
            'join_date' => 'required',
            'is_present' => 'required',
        ];
    }
}
