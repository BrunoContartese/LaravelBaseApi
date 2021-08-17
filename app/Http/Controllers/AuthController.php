<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Models\User;
use Facades\App\Services\Administration\UsersService;
use Facades\App\Services\Auth\AuthService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $http = new Client;

        try {
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->email,
                    'password' => $request->password,
                ]
            ]);

            return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            switch ($e->getCode()) {
                case 401:
                    return response()->json([
                        'errors' => [
                            'password' => 'Las credenciales ingresadas son incorrectas.',
                        ],
                    ], $e->getCode());
                    break;
                default:
                    return response()->json('Ha ocurrido un error en el servidor.', $e->getCode());
                    break;
            }
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Sesion cerrada correctamente.', 200);
    }

    public function user()
    {
        return User::with('roles', 'roles.permissions')->findOrFail(Auth::user()->id);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = AuthService::updatePassword($request);
        return response()->json(Auth::user(), Response::HTTP_OK);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = AuthService::updateProfile($request);
        return response()->json(Auth::user(), Response::HTTP_OK);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );
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
}
