<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Models\Brand;
use Illuminate\Http\Exceptions\HttpResponseException;

class BrandRequest extends FormRequest
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
           'name' => 'required',
           'url' => 'required|regex:/^[\pL\s\-]+$/u'

        ];
    }

    public function messages()
    {
        return [
           'name.required' => 'Brand Name is Required',
           'url.required' => 'Brand URL is Required'
        ];
    }

    //prepare request before validation

    public function prepareForValidation()
    {
        if($this->route('brand')){
            $this->merge([
                'id' =>$this->route('brand'),
            ]);
        }
    }

     public function withValidator($validator){
        $validator->after(function($validator){
            $brandCount = Brand::where('url', $this->input('url'));
            if($this->filled('id')){
                $brandCount->where('id', '!=', $this->input('id'));
            }
            if($brandCount->count() > 0){
                $validator->errors()->add('url','Brand URL Exists!');
            }
        });
    }

                // validate failure response
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
    }
}
