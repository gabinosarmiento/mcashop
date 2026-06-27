<?php

namespace App\Http\Requests\Administrative;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
        return ['search' => 'required|max:50'];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return ['search' => 'buscar'];
    }
}