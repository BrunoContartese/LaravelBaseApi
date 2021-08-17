<?php


namespace App\Services\Auth;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
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
            'birthdate' => $request->birthdate,
            'picture' => $request->picture,
            'email' => $request->email,
        ]);
    }
}
