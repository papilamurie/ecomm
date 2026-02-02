<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UserFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //if you have admin guard, check it; otherwise rely on is_admin flag
        if(auth()->guard('admin')->check()){

             return true;
        }

         if (auth()->check()){

            $user = auth()->user();
            if(isset($user->is_admin) && (int)$user->is_admin === 1){
                return true;
            }

        }
        return false;
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          'search' => 'nullable|string|max:255'
        ];
    }
}
