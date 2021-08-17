<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Services\Administration\PermissionsService;
use Symfony\Component\HttpFoundation\Response;

class PermissionsController extends Controller
{
    private $service;

    public function __construct(PermissionsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $permissions = $this->service->index();
        return response()->json($permissions, Response::HTTP_OK);
    }
}
