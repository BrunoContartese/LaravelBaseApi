<?php

namespace App\Http\Requests\Administration\Roles;

use App\Models\Spatie\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRoleRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->can('roles.edit');
    }

    public function rules()
    {
        $rules = Role::$rules;
        $rules["name"] = "required|unique:roles,name,{$this->route()->parameter('role')}";
        return $rules;
    }

    public function messages()
    {
        return Role::$messages;
    }
}
