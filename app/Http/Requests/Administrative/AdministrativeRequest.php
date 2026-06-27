<?php

namespace App\Http\Requests\Administrative;

use Illuminate\Foundation\Http\FormRequest;

class AdministrativeRequest extends FormRequest
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
        return ['id' => ['sometimes', 'integer'], 'firstname' => ['required', 'max:50'], 'lastname' => ['required', 'max:50'], 'department' => ['required', 'max:30'], 'email' => ['required', 'email', 'max:50', "unique:administrative,email,{$this->id},id"], 'password' => ['sometimes', 'nullable', 'string', 'min:6', 'regex:/^(?=.*[0-9])(?=.*[^\w\s]).{6,}$/'], 'status' => ['required', 'in:Activo,Cancelado']];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return ['firstname' => 'nombre', 'lastname' => 'apellido', 'email' => 'correo', 'department' => 'departamento', 'password' => 'contraseña', 'status' => 'estatus'];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return ['password.regex' => 'La contraseña debe tener al menos 6 caracteres, incluir un número y un carácter especial.'];
    }
}
