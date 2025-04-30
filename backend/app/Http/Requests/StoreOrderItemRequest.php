<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'name' => ['required', 'string'],
            'quantity' => ['required', 'integer'],
            'price' => ['required', 'integer'],
        ];
    }
}
