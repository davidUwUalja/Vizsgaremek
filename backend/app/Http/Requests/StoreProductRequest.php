<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_hu' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'material_hu' => 'required|string|max:255',
            'material_en' => 'required|string|max:255',
            'description_hu' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price_hu' => 'required|numeric|min:0',
            'price_en' => 'required|numeric|min:0',
            'image_url' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'category_hu' => 'nullable|string',
            'category_en' => 'nullable|string'
        ];
    }
}
