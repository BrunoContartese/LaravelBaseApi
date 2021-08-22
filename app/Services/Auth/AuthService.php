<?php


namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Validation\ValidationException;

class AuthService
{

    public function login($request)
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

            return $response;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            switch ($e->getCode()) {
                case 400:
                    throw ValidationException::withMessages([
                        'credentials' => "Las credenciales ingresadas son incorrectas."
                    ]);
                    break;
                case 401:
                    throw ValidationException::withMessages([
                        'credentials' => "Las credenciales ingresadas son incorrectas."
                    ]);
                    break;
                default:
                    throw ValidationException::withMessages([
                        'error' => "Ha ocurrido un error en el sistema."
                    ]);
                    break;
            }
        }
    }

    public function deleteTokens()
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
    }

    public function user()
    {
        return User::with('roles', 'roles.permissions')->findOrFail(Auth::user()->id);
    }

    public function updatePassword($request)
    {
        return Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);
    }

    public function updateProfile($request)
    {
        return Auth::user()->update([
            'given_name' => $request->given_name,
            'family_name' => $request->family_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ]);
    }

    public function updateProfilePicture($request)
    {
        return Auth::user()->update([
            'picture' => $request->picture,
        ]);
    }

    public function sendResetLinkEmail($request)
    {
       return Password::sendResetLink(
            $request->only('email')
        );
    }
}
