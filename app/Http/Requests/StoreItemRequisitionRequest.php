<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequisitionRequest extends FormRequest
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
            'requisition_id' => 'required',
            'product_id'=> 'required',
            'quantity' => 'required',
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
            $this->except(['_token'])
        );
    }
}
