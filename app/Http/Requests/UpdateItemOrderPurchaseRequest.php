<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemOrderPurchaseRequest extends FormRequest
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
            'purchase_order_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'subtotal' => 'required',
        ];
    }

    public function messages(){
        return [
        'required' => 'El :attribute es requerido' ,
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(
            $this->except(['_token', ('_method')])

        );
    }
}
