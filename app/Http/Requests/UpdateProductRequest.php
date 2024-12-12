<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'description' => 'required',
            'brand' => 'required',
            'quantity' => 'required',
            'udm' => 'required',
            'category' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'tax_id' => 'required',   
        ];
    }

    public function messages(){
        return [
        'required' => 'El :attribute es requerido' ,
        'numeric' => 'El :attribute debe ser numerico',

        
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(
            $this->except(['_token', ('_method')])
        );
    }
}
