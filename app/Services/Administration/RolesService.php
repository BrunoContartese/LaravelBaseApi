<?php

namespace App\Services\Administration;

use App\Models\Spatie\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RolesService
{
    private $relations = [];

    public function index($request)
    {
        $roles = Role::query();

        if ($request->has('query')) {
            $roles->where('name', 'like', "%{$request->query}%");
        }

        if ($request->has('orderBy')) {
            $roles->orderBy($request->orderBy, $request->orderType);
        }

        return $roles->get();
    }

    public function paginated($request)
    {
        $roles = Role::query();

        if ($request->has('query')) {
            $roles->where('name', 'like', "%{$request->query}%");
        }

        if ($request->has('orderBy')) {
            $roles->orderBy($request->orderBy, $request->orderType);
        }

        return $roles->paginate($request->pageSize);
    }

    public function findById($id)
    {
        return Role::findOrFail($id);
    }

    public function store($data)
    {
        try {
            return Role::create([
                'name' => $data->name,
                'is_editable' => $data->is_editable,
                'guard_name' => 'api'
            ]);
        } catch (\Exception $e) {
            Log::warning("Excepción capturada (RolesService.store): " . $e->getMessage() . "\n");
            throw $e;
        }
    }

    public function update($request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            if (!$role->is_editable) {
                throw ValidationException::withMessages([
                    'is_editable' => 'No puede actualizar los datos del rol seleccionado.'
                ]);
            }

            $role->update($request->all());
            return $role;
        } catch (\Error $e) {
            Log::warning("Excepción capturada (RolesService.update): " . $e->getMessage() . "\n");
            throw $e;
        }
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
    }

    public function syncPermissions($id, $data)
    {
        try {
            $role = Role::findOrFail($id);
            $role->syncPermissions([]);
            foreach ($data->permissions as $permission) {
                $role->givePermissionTo($permission['id']);
            }
            return $role;
        } catch (\Error $e) {
            Log::warning("Excepción capturada (RolesService.syncPermissions): " . $e->getMessage() . "\n");
            throw $e;
        }
    }
}
