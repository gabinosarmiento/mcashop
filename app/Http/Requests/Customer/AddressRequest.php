<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth('customer')->check();
    }

    /*
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['customer_id' => auth('customer')->id()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ['id' => 'sometimes|integer', 'customer_id' => 'required|integer', 'name' => 'required|max:100', 'phone' => 'required|digits:10', 'email' => 'required|email|max:50', 'street' => 'required|max:100', 'streets' => 'required|max:200', 'reference' => 'nullable|max:100', 'zc' => 'required|digits:5|exists:up_colonies,zc', 'colony' => 'required|max:100', 'city' => 'required|max:100', 'state' => 'required|max:50', 'country' => 'required|in:México'];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return ['name' => 'nombre', 'phone' => 'teléfono', 'email' => 'correo electrónico', 'street' => 'calle, número', 'streets' => 'entre calles', 'reference' => 'referencia', 'zc' => 'código postal', 'colony' => 'colonia', 'city' => 'municipio', 'state' => 'estado', 'country' => 'país'];
    }
}
