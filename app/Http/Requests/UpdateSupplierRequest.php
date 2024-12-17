<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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

            'name' => 'required',
           'rfc' => 'required|string|max:13',
            'number' => 'required|string|max:12',
            'address' => 'required',
            'email' => 'nullable|email',            
            'critic' => 'required',
            'currency' => 'required',
            'credit_days' => 'required',
            'unique' => 'required',      
            'account' => 'nullable',       

        ];
    }

    public function messages(){
        return [
        'required' => 'El :attribute es requerido' ,
        'numeric' => 'El :attribute debe ser numerico',
        'rfc.max' => 'El RFC no puede tener más de 13 caracteres.',
        'number.max' => 'El número de contacto no puede tener más de 12 caracteres.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(
            $this->except(['_token', ('_method')])
        );
    }
}
