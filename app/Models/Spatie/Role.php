<?php

namespace App\Models\Spatie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends \Spatie\Permission\Models\Role
{
    protected $guard_name = 'api';

    protected $fillable = [
        'name',
        'is_editable',
        'guard_name'
    ];

    public static $rules = [
        'name' => 'required|unique:roles,name'
    ];

    public static $messages = [
        'name.required' => 'Debe ingresar el nombre del rol.',
        'name.unique' => 'El nombre ingresado ya existe en la base de datos.'
    ];

    protected $hidden = [
      'created_at',
      'updated_at',
      'guard_name'
    ];
}
