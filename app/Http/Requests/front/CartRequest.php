<?php

namespace App\Http\Requests\front;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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

        $routeName = $this->route() ? $this->route()->getName() : null;
        $method = $this->method();
        $rules = [];
        if($routeName === 'cart.store' || ($method === 'POST' && $this->routeIs('cart.store'))){
            $rules = [
                'product_id' => 'required|exists:Products,id',
                'size' => 'required|string',
                'qty' => 'required|integer|min:1',
            ];
        }elseif($routeName === 'cart.update' || ($method === 'PATCH' && $this->routeIs('cart.update'))){
            $rules = [
                'qty' => 'required|integer|min:1', //cart_id is from route param; validation from controller or impicitly via route model binding

            ];
        }elseif($routeName === 'cart.destroy' || ($method === 'DELETE' && $this->routeIs('cart.destroy'))){
            $rules = [
                //no field required for destroy
            ];
        }

        return $rules;
    }

    public function messages(): array{
        return [
            'product_id.required' => 'Product is Required',
            'product_id.exists' => 'Product not Found',
            'size.required' => 'Please Select a Size',
            'qty.required' => 'Please enter quantity.',
        ];
    }
}
