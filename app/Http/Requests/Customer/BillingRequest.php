<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class BillingRequest extends FormRequest
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
        $this->merge(['customer_id' => auth('customer')->id(), 'rfc' => strtoupper(trim($this->rfc))]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ['id' => 'sometimes|integer', 'customer_id' => 'required|integer', 'name' => 'required|max:100', 'rfc' => ['required', 'regex:/^([A-ZÑ&]{3,4})?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01]))?(?:- ?)?([A-Z\d]{2})([A\d])$/', "unique:customer_billing,rfc,{$this->id},id,customer_id,{$this->customer_id}"], 'regime' => 'required|integer', 'phone' => 'required|digits:10', 'email' => 'required|email|max:50', 'zc' => 'required|digits:5|exists:up_colonies,zc'];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return ['name' => 'nombre', 'rfc' => 'RFC', 'regime' => 'régimen', 'phone' => 'teléfono', 'email' => 'correo electrónico', 'zc' => 'código postal'];
    }
}
