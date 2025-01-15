<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequisitionRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
        'status_requisition' => 'required|string',
        'importance' => 'required|string',
        'finished' => 'required|boolean',
        'request_date' => 'required|date',
        'production_date' => 'nullable',
        'days_remaining' => 'required|integer',
        'finished_date' => 'nullable',
        'items_requisition' => 'required|array|min:1',
        'items_requisition.*.product_id' => 'required|exists:products,id',
        'items_requisition.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(){
        return [
        'required' => 'El campo :attribute requerido' ,
        'items_requisition.required' => 'Debes agregar al menos un ítem a la requisición.',
        'items_requisition.*.product_id.required' => 'Cada ítem debe tener un producto asociado.',
        'items_requisition.*.quantity.required' => 'Cada ítem debe tener una cantidad.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(
            $this->except(['_token'])
        );
    }
}
