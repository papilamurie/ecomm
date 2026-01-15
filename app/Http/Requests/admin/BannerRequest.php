<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
           'type' => 'required|string|max:255',
           'link' => 'nullable|url|max:500',
           'title' => 'required|string|max:255',
           'alt' => 'nullable|string|max:255',
           'sort' => 'nullable|integer|min:0',
           'status' => 'nullable|in:0,1',
        ];
        // for create or edit image validate via uploading

        if($this->isMethod('post') || $this->hasFile('image')){
            $rules['image'] = 'required|image|mimes:jpg,jpeg,png,gif|max:2048'; // Max 2MB
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Please Select a Banner Type',
            'title.required' => 'Banner Title is Required',
            'image.required' => 'Please Upload a Banner Image',
            'image.image' => 'Uploaded file must be an image',
            'image.mimes' => 'Allowed images type are jpg, jpeg, png, gif',
            'image.max' => 'Image size must be less than 2MB',
        ];
    }
}
