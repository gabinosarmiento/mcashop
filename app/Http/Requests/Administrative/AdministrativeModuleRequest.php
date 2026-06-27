<?php

namespace App\Http\Requests\Administrative;

use Illuminate\Foundation\Http\FormRequest;

class AdministrativeModuleRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return ['administrative_id' => 'required|integer', 'module' => "required|unique:administrative_module,module,null,null,administrative_id,{$this->administrative_id}"];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return ['administrative_id' => 'administrativo', 'module' => 'módulo'];
    }
}
