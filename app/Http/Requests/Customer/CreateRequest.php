<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['firstname' => 'required|string|max:50', 'lastname' => 'required|string|max:50', 'phone' => 'required|digits:10', 'email' => 'required|email|max:50|unique:up_customer,email', 'password' => ['required', 'string', 'min:6', 'regex:/^(?=.*[0-9])(?=.*[^\w\s]).{6,}$/'], 'repassword' => 'required|same:password', 'terms' => 'accepted'];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return ['firstname' => 'nombre', 'lastname' => 'apellido', 'phone' => 'teléfono', 'email' => 'correo electrónico', 'password' => 'contraseña', 'repassword' => 'repetir contraseña', 'terms' => 'políticas de privacidad'];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ['password.regex' => 'La contraseña debe tener al menos 6 caracteres, incluir un número y un carácter especial.', 'terms.accepted' => 'Debes aceptar las políticas de privacidad.'];
    }
}
