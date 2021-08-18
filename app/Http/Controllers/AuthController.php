<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        $response = $this->service->login($request);

        return $response->getBody();
    }

    public function logout(Request $request)
    {
        $this->service->deleteTokens();
        return response()->json('Sesion cerrada correctamente.', 200);
    }

    public function user()
    {
        $user = $this->service->user();
        return response()->json($user, Response::HTTP_OK);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $this->service->updatePassword($request);
        return response()->json(Auth::user(), Response::HTTP_OK);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->service->updateProfile($request);
        return response()->json(Auth::user(), Response::HTTP_OK);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {

        $status = $this->service->sendResetLinkEmail($request);
        return $status === Password::RESET_LINK_SENT
            ? response()->json("Se ha envíado un email a {$request->email} con las instrucciones para restablecer la contraseña", Response::HTTP_OK)
            : response()->json(['email' => __($status)], Response::HTTP_BAD_REQUEST);
    }

    public function passwordResetView()
    {
        return view('auth.reset-password');
    }

    public function passwordReset(ResetPasswordRequest $request)
    {
        $reset_password_status = Password::reset($request->all(), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json('Token inválido.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return redirect(env('FRONT_END_URL', '/'));
    }

    public function updatePicture(UpdateProfileRequest $request)
    {
        $user = $this->service->updateProfilePicture($request);
        return response()->json(Auth::user(), Response::HTTP_OK);
    }
}
