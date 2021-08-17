<?php

namespace App\Http\Requests\Administration\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->can('users.edit');
    }

    public function rules()
    {
        $rules = User::$rules;
        $rules['email'] = "email|unique:users,email,{$this->route()->parameter('user')}";
        return $rules;
    }

    public function messages()
    {
        return User::$messages;
    }
}
