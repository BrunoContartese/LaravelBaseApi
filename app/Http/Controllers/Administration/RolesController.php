<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\Roles\SetCommissionPerSaleRequest;
use App\Http\Requests\Administration\Roles\StoreRoleRequest;
use App\Http\Requests\Administration\Roles\SyncPermissionsRequest;
use App\Http\Requests\Administration\Roles\UpdateRoleRequest;
use App\Http\Requests\Pagination\PaginatorRequest;
use App\Services\Administration\RolesService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    private $service;
    public function __construct(RolesService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $roles = $this->service->index($request);
        return response()->json($roles, Response::HTTP_OK);
    }

    public function paginated(PaginatorRequest $request)
    {
        $roles = $this->service->paginated($request);
        return response()->json($roles, Response::HTTP_OK);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = $this->service->store($request);
        return response()->json($role, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $role = $this->service->findById($id);
        return response()->json($role, Response::HTTP_OK);
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $role = $this->service->update($request, $id);
        return response()->json($role, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function syncPermissions($id, SyncPermissionsRequest $request)
    {
        $role = $this->service->syncPermissions($id, $request);
        return response()->json($role, Response::HTTP_OK);
    }
}
