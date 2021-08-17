<?php

namespace App\Models\Spatie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected $guard_name = 'api';

    protected $hidden = [
        'created_at',
        'updated_at',
        'guard_name'
    ];
}
