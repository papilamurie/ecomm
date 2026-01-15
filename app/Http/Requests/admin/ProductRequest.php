<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'category_id' => 'required',
           'brand_id' => 'required',
           'product_name' => 'required|max:200',
           'product_code' => 'required|max:30',
           'product_price' => 'required|numeric|gt:0',
           'product_color' => 'required|max:200',
           'family_color' => 'required|max:200'
        ];
    }
    public function messages()
    {
        return [
            'category_id.required' => "Category is Required",
            'brand_id.required' => "Brand is Required",
            'product_name.required' => "Product Name is Required",
            'product_name.regex' => "Valid Product Name is Required",
            'product_code.required' => "Product Code is Required",
            'product_price.required' => "Product Price is Required",
            'product_price.numeric' => "Valid Product Price is Required",
            'product_color.required' => "Product Color is Required",
            'family_color.required' => "Family Color is Required"

        ];
    }
}
