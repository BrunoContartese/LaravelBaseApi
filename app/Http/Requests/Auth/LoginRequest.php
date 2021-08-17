<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Debe ingresar su nombre de dirección de correo electrónico.',
            'email.exists' => 'La dirección de correo electrónico ingresada no existe en nuestros registros.',
            'password.required' => 'Debe ingresar su contraseña.'
        ];
    }
}
