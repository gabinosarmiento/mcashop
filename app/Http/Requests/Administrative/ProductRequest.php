<?php

namespace App\Http\Requests\Administrative;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return ['id' => 'nullable|integer', 'brand_id' => 'required|integer', 'category_id' => 'nullable|integer', 'sku' => 'required|max:50', 'gtin' => 'sometimes|nullable|min:8|max:14', 'name' => 'required|max:500', 'subname' => 'sometimes|nullable|max:500', 'weight' => 'sometimes|nullable|numeric', 'description' => 'sometimes|nullable|max:4000', 'review' => 'sometimes|nullable|max:2000', 'note' => 'sometimes|nullable|max:200', 'status' => 'required|in:Borrador,Activo,Cancelado'];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return ['brand_id' => 'marca', 'category_id' => 'categoría', 'sku' => 'sku', 'gtin' => 'gtin', 'name' => 'nombre', 'subname' => 'subnombre', 'weight' => 'peso', 'description' => 'descripción', 'review' => 'resumen', 'note' => 'nota', 'status' => 'estatus'];
    }
}