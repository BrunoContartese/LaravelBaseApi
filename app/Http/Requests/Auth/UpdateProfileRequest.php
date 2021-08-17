<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'given_name' => 'required',
            'family_name' => 'required',
            'phone_number' => 'required',
            'birthdate' => 'required|date',
            'email' => "required|email|unique:users,email," . Auth::user()->id,
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El campo email no puede estar vacío.',
            'email.unique' => 'El email ingresado se encuentra utilizaado por otro usuario.',
            'email.email' => 'El email ingresado no es válido.',
            'given_name.required' => 'Debe ingresar su nombre.',
            'family_name.required' => 'Debe ingresar  su apellido.',
            'birthdate.required' => 'Debe ingresar su fecha de nacimiento.',
            'birthdate.date' => 'La fecha de nacimiento ingresada no es válida.',
        ];
    }
}
