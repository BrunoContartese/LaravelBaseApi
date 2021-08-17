<?php


namespace App\Services\Administration;


use App\Models\Spatie\Permission;

class PermissionsService
{
    public function index()
    {
        return Permission::all();
    }
}
