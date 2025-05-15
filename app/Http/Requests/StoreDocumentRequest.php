<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
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
            'code' => 'required',
            'name'=> 'required',
            'description' => 'nullable',
            'version' => 'required',
            'category_id' => 'nullable',
            'download' => 'required',
            'general' => 'required',
            'file_pdf' => 'nullable|file|max:20480|mimes:pdf',
            'file_doc' => 'nullable|file|max:20480|mimes:png,jpg,jpeg,pdf,docx,doc,xls,xlsx,ppt,pptx',
            'revisor_id'=> 'nullable',
            'aprobador_id' => 'nullable',
            'area_resp_id' => 'nullable',
            'auth_1' => 'required',
            'auth_2' => 'required',
            'active' => 'required',

            'areas' => 'required|array',
            'areas.*' => 'exists:areas_sgi,id'

        ];
    }

     public function messages()
{
    return [
        'code.required' => 'El código es requerido',
        'name.required' => 'El nombre es requerido',
        'version.required' => 'La versión es requerida',
        'download.required' => 'Especifica si el documento es descargable',
        'general.required' => 'Especifica si el documento es general',
        'file_pdf.mimes' => 'Formato no válido. Los formatos permitidos son: pdf', 
        'file_doc.mimes' => 'Formato no válido. Los formatos permitidos son: png, jpg, jpeg, pdf, docx, doc, xls, xlsx, ppt, pptx',
        'auth_1.required' => 'El estado del revisor es obligatorio',
        'auth_2.required' => 'El estado del aprobador es obligatorio',
        'active.required' => 'El estado activo/inactivo es obligatorio',
    ];
}

    protected function prepareForValidation()
    {
        $this->merge(
            $this->except(['_token'])
        );
    }
}
