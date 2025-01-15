<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseOrderRequest extends FormRequest
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

            'supplier_id' => 'required',
            'requisition_id' => 'required',
            'tax_id' => 'required',
            'importance_op' => 'required',
            'type_op' => 'required',
            'date_start' => 'required',
            'date_end' => 'nullable',
            'status_time' => 'required',
            'payment_type' => 'required',
            'payment_condition' => 'required',
            'payment_display' => 'required',
            'status_1' => 'required',
            'status_2' => 'required',
            'status_3' => 'required',
            'status_4' => 'required',
            'po_status' => 'required',
            'bill' => 'required',
            'finished' => 'required',
            'currency' => 'required',
            'subtotal' => 'required',
            'tax' => 'required',
            'total' => 'required',
        ];
    }

    public function messages(){
        return [
        'required' => 'El campo :attribute requerido' ,
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(
            $this->except(['_token', ('_method')])
        );
    }
}
