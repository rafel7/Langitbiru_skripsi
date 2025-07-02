<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Izinkan semua pengguna mengakses request ini
    }

    public function rules()
    {
        return [
            'nim' => 'required|nim|exists:users,nim',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'nim.required' => 'nim wajib diisi.',
            'nim.nim' => 'Format nim tidak valid.',
            'nim.exists' => 'nim tidak ditemukan dalam sistem.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ];
    }
}
