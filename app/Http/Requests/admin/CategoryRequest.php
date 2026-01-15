<?php

namespace App\Http\Requests\admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Category;

class CategoryRequest extends FormRequest
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
           'category_name' => 'required',
           'url' => 'required|regex:/^[\pL\s\-]+$/u'

        ];
    }
    public function messages()
    {
        return [
           'category_name.required' => 'Category Name is Required',
           'url.required' => 'Category URL is Required'
        ];
    }

            //prepare request before validation

    public function prepareForValidation()
    {
        if($this->route('category')){
            $this->merge([
                'id' =>$this->route('category'),
            ]);
        }
    }
            //checking unique url
    public function withValidator($validator){
        $validator->after(function($validator){
            $categoryCount = Category::where('url', $this->input('url'));
            if($this->filled('id')){
                $categoryCount->where('id', '!=', $this->input('id'));
            }
            if($categoryCount->count() > 0){
                $validator->errors()->add('url','Category URL Exists!');
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
