<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email|min:8',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Debe ingresar su dirección de email',
            'email.email' => 'El email ingresado no es una dirección válida.',
            'email.exists' => 'El email ingresado no corresponde a un usuario del sistema.',
            'token.required' => 'El token no es válido.',
            'password.required' => 'Debe ingresar su nueva contraseña.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe contener como mínimo :min caracteres.'
        ];
    }
}
