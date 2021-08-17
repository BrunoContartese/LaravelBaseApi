<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'errors' => [
                    'error' => 'No se han encontrado registros.'
                ],
                'model' => $exception->getModel()
            ], 404);
        }

        if ($exception instanceof \Error) {
            return response()->json([
                'errors' => [
                    'error' => 'Ha ocurrido un error de sistema, si persiste por favor contáctese a soporte@estoes.me.'
                ]
            ], 500);
        }

        if ($exception instanceof \BadMethodCallException) {
            return response()->json([
                'errors' => [
                    'error' => 'Ha ocurrido un error de sistema, si persiste por favor contáctese a soporte@estoes.me.'
                ]
            ], 500);
        }

        if ($exception instanceof UnauthorizedException) {
            return response()->json([
                'errors' => [
                    'error' => 'Usted no posee permisos para realizar esta acción.'
                ]
            ], 403);
        }

        return parent::render($request, $exception);
    }
}
