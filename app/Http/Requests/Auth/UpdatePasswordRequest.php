<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => 'required|min:8|confirmed',
            'old_password' => 'required|password'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Debe ingresar su nueva contraseña.',
            'password.min' => 'La contraseña debe tener como mínimo :min caracteres.',
            'old_password.required' => 'Debe ingresar contraseña anterior.',
            'old_password.password' => 'Su contraseña anterior no es válida.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ];
    }
}
