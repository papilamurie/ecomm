<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
{
    $this->merge([
        'is_base' => $this->has('is_base') ? 1 : 0,
    ]);

    if ($this->has('code')) {
        $this->merge(['code' => strtoupper(trim($this->input('code')))]);
    }

    if ($this->has('name')) {
        $this->merge(['name' => trim($this->input('name'))]);
    }
}


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get currency ID from route parameter
        $currencyId = $this->route('currency') ?? $this->route('id') ?? null;

        // Handle if it's a model instance
        if (is_object($currencyId) && property_exists($currencyId, 'id')) {
            $currencyId = $currencyId->id;
        }

        // Create unique rule
        $codeUnique = $currencyId
            ? Rule::unique('currencies', 'code')->ignore($currencyId)
            : Rule::unique('currencies', 'code');

        return [
            'code' => ['required', 'string', 'max:10', $codeUnique],
            'symbol' => ['nullable', 'string', 'max:10'],
            'name' => ['nullable', 'string', 'max:255'],
            'rate' => ['required', 'numeric', 'min:0'],
            'status' => ['sometimes', 'in:0,1'],
            'is_base' => ['sometimes', 'boolean'],
            'flag' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Currency code is required',
            'code.unique' => 'This currency code already exists',
            'rate.required' => 'Exchange rate is required',
            'rate.numeric' => 'Exchange rate must be a number',
            'rate.min' => 'Exchange rate cannot be negative',
            'flag.image' => 'Flag must be an image file',
            'flag.mimes' => 'Flag must be a PNG, JPG, JPEG, or SVG file',
            'flag.max' => 'Flag size cannot exceed 2MB',
        ];
    }
}
