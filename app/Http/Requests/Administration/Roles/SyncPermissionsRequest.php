<?php

namespace App\Http\Requests\Administration\Roles;

use App\Models\Spatie\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SyncPermissionsRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->can('roles.edit');
    }

    public function rules()
    {
        return [
            'permissions' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'permissions.required' => 'Debe seleccionar al menos 1 permiso.',
            'permissions.array' => 'Debe seleccionar al menos 1 permiso.'
        ];
    }
}
