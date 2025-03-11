<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseOrderRequest extends FormRequest
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
            'requisition_id' => 'required|exists:requisitions,id',
            'supplier_id' => 'required|exists:suppliers,id',

            'subtotal' => 'required',
            'total' => 'required',

            'items_order' => 'required|array|min:1',
            'items_order.*.product_id' => 'required|exists:products,id',
            'items_order.*.quantity' => 'required|numeric|min:1',
            'items_order.*.price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute requerido',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(
            $this->except(['_token'])
        );
    }
}
