<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class FilterValueRequest extends FormRequest
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
        // match route parameter name exactly
        $filterValueId = $this->route('value'); // null or create
        $filterId = $this->route('filter');
        return [
            'value' => 'required|string|max:255|unique:filter_values,value,' . $filterValueId . ',id,filter_id,' . $filterId,
            'sort' => 'nullable|integer',
            'status' => 'required|in:0,1',
        ];
    }

    public function messages()
    {
        return [
            'value.required' => 'The Filter Value field is required.',
            'value.unique' => 'The Filter Value has already been taken for this filter.',
        ];
    }
}
