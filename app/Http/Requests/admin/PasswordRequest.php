<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
           'current_pwd' =>['required', 'string', 'min:6'],
           'new_pwd' => ['required', 'string', 'min:6', 'different:current_pwd'],
           'confirm_pwd' => ['required', 'string', 'same:new_pwd']
        ];
    }
    public function messages()
    {
        return [
            'current_pwd.required' =>  'Current Password is Required',
            'current_pwd.min' =>  'Current Password should be at least 6 characters',
            'new_pwd.required' =>  'New Password is Required',
            'new_pwd.min' =>  'New Password should be at least 6 characters',
            'new_pwd.different' =>  'New Password must be different from the current password',
            'confirm_pwd.required' =>  'Confirm Password is Required',
            'confirm_pwd.same' =>  'Confirm Password must match New Password',
        ];
    }
}
