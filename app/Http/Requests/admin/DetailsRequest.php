<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class DetailsRequest extends FormRequest
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
           'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
           'mobile' => 'required|numeric|digits:11',
           'image' => 'image'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => "Name is Required",
            'name.regex' => "Valid Name is Required",
            'name.max' => "Valid Name is Required",
            'mobile.required' => "Mobile is Required",
            'mobile.numeric' => "Valid Mobile is Required",
            'mobile.digits' => "Valid Mobile is Required",
            'image.image' => "Valid Image is Required"
        ];
    }
}
