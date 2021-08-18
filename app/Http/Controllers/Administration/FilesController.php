<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\Files\StoreFileRequest;
use App\Services\Administration\FilesService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilesController extends Controller
{
    private $filesService;

    public function __construct(FilesService $filesService)
    {
        $this->filesService = $filesService;
    }

    public function store(StoreFileRequest $request)
    {
        $file = $this->filesService->store($request);
        return response()->json($file, Response::HTTP_OK);
    }
}
