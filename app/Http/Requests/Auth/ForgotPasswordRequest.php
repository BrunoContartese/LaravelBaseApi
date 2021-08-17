<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Debe ingresar su dirección de email',
            'email.email' => 'El email ingresado no es una dirección válida.',
            'email.exists' => 'El email ingresado no corresponde a un usuario del sistema.'
        ];
    }
}
