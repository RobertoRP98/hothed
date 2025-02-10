<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequisBetaRequest extends FormRequest
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

            'dep_soli' => 'nullable',
            'requisicion' => 'nullable',
            'fecha_requi' => 'nullable',
            'prioridad' => 'nullable',
            'comentario' => 'nullable',
            'orden_compra' => 'nullable',
            'fecha_coti' => 'nullable',
            'status_oc' => 'nullable',
            
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(
            $this->except(['_token'])
        );
    }

    
}
