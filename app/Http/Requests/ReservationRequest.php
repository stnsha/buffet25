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

            '1_quantity' => ['nullable', 'integer', 'min:0'],
            '2_quantity' => ['nullable', 'integer', 'min:0'],
            '3_quantity' => ['nullable', 'integer', 'min:0'],
            '7_quantity' => ['nullable', 'integer', 'min:0'],
            '8_quantity' => ['nullable', 'integer', 'min:0'],
            '9_quantity' => ['nullable', 'integer', 'min:0'],
            '10_quantity' => ['nullable', 'integer', 'min:0'],

            '4_quantity' => ['nullable', 'integer', 'min:0'],
            '5_quantity' => ['nullable', 'integer', 'min:0'],
            '6_quantity' => ['nullable', 'integer', 'min:0'],

            '3_price' => ['nullable', 'numeric', 'min:0'],
            '1_price' => ['nullable', 'numeric', 'min:0'],
            '2_price' => ['nullable', 'numeric', 'min:0'],

            '7_price' => ['nullable', 'numeric', 'min:0'],
            '8_price' => ['nullable', 'numeric', 'min:0'],

            '4_price' => ['nullable', 'numeric', 'min:0'],
            '5_price' => ['nullable', 'numeric', 'min:0'],
            '6_price' => ['nullable', 'numeric', 'min:0'],
            '9_price' => ['nullable', 'numeric', 'min:0'],
            '10_price' => ['nullable', 'numeric', 'min:0'],
            'subtotal' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Sila isi nama anda.',
            'phone.required' => 'Sila isi no. telefon anda.',
            'subtotal.min' => 'Sila pilih jumlah pax sebelum membuat pembayaran.',
        ];
    }
}