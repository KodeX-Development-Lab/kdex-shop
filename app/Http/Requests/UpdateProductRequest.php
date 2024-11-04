<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('product');
        return [
            'name_mm' => 'required|unique:products,name_mm,'.$id,
            'name_en' => 'required|unique:products,name_en,'.$id,
            'description' => 'required',
            'category_id' =>'required',
            'supplier_id'=>'required',
            'color_id' => 'required',
            'brand_id'=>'required',
            'buy_price'=>'required',
            'sale_price'=>'required',
            'discount_price'=>'required',
            'total_qty'=>'required',
        ];
    }
}
