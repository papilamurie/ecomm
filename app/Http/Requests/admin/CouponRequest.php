<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
         $id = $this->route('coupon') ?? $this->input('id');


            $rules = [
                'coupon_option' => 'nullable|string|in:Automatic,Manual,automatic,manual',
                'coupon_code' => 'required|string|max:500|unique:coupons,coupon_code' . ($id ? ",$id" : ''),
                'coupon_type' =>'nullable|string|in:Single,Multiple,single,multiple',
                'amount_type' => 'required|string|in:percentage,fixed,Percentage,Fixed',
                'amount' => 'required|numeric|min:0',
                'expiry_date' => 'nullable|date',
                'min_qty' => 'nullable|integer|min:0',
                'max_qty' => 'nullable|integer|min:0',
                'min_cart_value' => 'nullable|numeric|min:0',
                'max_cart_value' => 'nullable|numeric|min:0',
                'usage_limit_per_user' => 'nullable|integer|min:0',
                'total_usage_limit' => 'nullable|integer|min:0',
                'visible' => 'nullable|in:0,1',
                'status' => 'nullable|in:0,1',
                //categories, brands, users are arrays (optional)
                'categories' => 'nullable|array',
                'brands' => 'nullable|array',
                'users' => 'nullable|array',
            ];

             return $rules;
    }

    protected function prepareForValidation()
    {
        // normalize some boolean fields
        $this->merge([
            'visible' => $this->has('visible') ? (int)$this->input('visible') : 0,
            'status' => $this->has('status') ? (int)$this->input('status') : 0,
        ]);
    }
}
