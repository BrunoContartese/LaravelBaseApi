<?php

namespace App\Http\Requests\Administration\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->can('users.create');
    }

    public function rules()
    {
        return User::$rules;
    }

    public function messages()
    {
        return User::$messages;
    }
}
