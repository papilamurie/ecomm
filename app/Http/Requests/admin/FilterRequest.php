<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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

        $filterId = $this->route('filter'); // null or create

        return [
            'filter_name' => 'required|max:100|unique:filters,filter_name,' . $filterId,
            'filter_column' => 'required|string|max:100|unique:filters,filter_column,' . $filterId,
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'sort' => 'nullable|integer|min:0',
            'status' => 'nullable|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'filter_name.required' => 'The Filter Name field is required.',
            'filter_name.unique' => 'The Filter Name has already been taken.',
            'filter_column.required' => 'The Filter Column field is required.',
            'filter_column.unique' => 'The Filter Column has already been taken.',
            'category_ids.required' => 'Please select at least one category.',

        ];
    }
}
