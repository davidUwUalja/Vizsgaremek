<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'zip' => ['required', 'integer', 'digits:4'],
            'currency' => ['required', 'integer', 'in:HUF,USD'],
            'total_price' => ['required', 'integer'],
            'status' => ['required', 'string', 'in:pending,completed,cancelled'],
        ];
    }
}
