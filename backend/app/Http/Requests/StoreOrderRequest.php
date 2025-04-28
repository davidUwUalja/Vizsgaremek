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
            'user_id' => ['required','exists:users,id'],
            'total_price' => ['required','integer','max:50'],
            'status' => ['sometimes','string','in:pending,completed,cancelled'], 
        ];
    }
}
