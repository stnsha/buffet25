<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:12'],
            'email' => ['nullable', 'email', 'max:255'],
            'selected_date' => ['required'],

            '1_quantity' => ['required', 'integer', 'min:0'],
            '2_quantity' => ['required', 'integer', 'min:0'],
            '3_quantity' => ['required', 'integer', 'min:0'],
            'baby_chair' => ['required', 'integer', 'min:0'],

            '3_price' => ['required', 'numeric', 'min:0'],
            '1_price' => ['required', 'numeric', 'min:0'],
            '2_price' => ['required', 'numeric', 'min:0'],
            'bchair_price' => ['nullable', 'string', 'in:FOC'],
            'subtotal' => ['required', 'numeric', 'min:0'],
        ];
    }
}
