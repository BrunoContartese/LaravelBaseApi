<?php

namespace App\Http\Requests\Administration\Roles;

use App\Models\Spatie\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRoleRequest extends FormRequest
{

    public function authorize()
    {
        return Auth::user()->can('roles.create');
    }

    public function rules()
    {
        return Role::$rules;
    }

    public function messages()
    {
        return Role::$messages;
    }
}
