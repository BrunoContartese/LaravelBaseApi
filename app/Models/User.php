<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Wildside\Userstamps\Userstamps;

class User extends Authenticatable
{
    use HasFactory,
        Notifiable,
        SoftDeletes,
        HasRoles,
        HasApiTokens,
        Userstamps,
        CanResetPassword;

    protected $fillable = [
        'given_name',
        'family_name',
        'phone_number',
        'picture',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = [
        'email' => 'email|unique:users,email',
        'password' => 'required|min:8',
        'given_name' => 'required',
        'family_name' => 'required',
        'roles' => 'required|array',
        'roles.*' => 'exists:roles,name'
    ];

    public static $messages = [
        'email.email' => 'Debe ingresar un email válido.',
        'email.required' => 'El campo email no puede estar vacío.',
        'email.unique' => 'El email ingresado ya se encuentra registrado en el sistema.',
        'password.required' => 'Debe ingresar una contraseña.',
        'password.min' => 'La contraseña debe contener como mínimo 8 caracteres.',
        'given_name.required' => 'Debe ingresar el nombre del usuario.',
        'family_name.required' => 'Debe ingresar el apellido del usuario.',
        'roles.required' => 'Debe indicar los roles del usuario.',
        'roles.*.exists' => 'El rol seleccionado no es válido.'
    ];

    protected function getDefaultGuardName(): string
    {
        return 'api';
    }

    public function findForPassport($username)
    {
        return $this->where('email', $username)->first();
    }
}
