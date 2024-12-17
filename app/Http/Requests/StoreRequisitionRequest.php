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
            'user_id' => 'required',
            'status_requisition' => 'required',
            'importance' => 'required',
            'finished' => 'required',
            'production_date' => 'required',
            'request_date' => 'required',

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
