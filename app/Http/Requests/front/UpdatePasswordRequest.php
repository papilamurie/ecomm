<?php

namespace App\Http\Requests\front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'current_password' => ['required','current_password'],
            'password' => ['required','confirmed',Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
        ];
    }

    public function messages()
    {
        return[
            'current_password.current_password' => 'Your current password is incorrect.',
            'password.confirmed'=>'New password confirmation does not match.',
        ];
    }
}
