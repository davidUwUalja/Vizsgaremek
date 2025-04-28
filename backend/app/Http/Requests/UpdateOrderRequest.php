<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'integer', 'max:4'],
            'currency' => ['required', 'string', 'in:HUF,USD'],
            'total_price' => ['required', 'integer', 'min:0'],
            'status' => ['sometimes', 'string', 'in:pending,completed,cancelled'],
        ];
    }
}
