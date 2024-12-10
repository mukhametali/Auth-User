<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{

    public function createUser(string $name, string $email, string $password, string $gender): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'gender' => $gender,
        ]);
    }

    public function login(string $email, string $password): array
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $token = $user->createToken('YourAppName')->plainTextToken;

            return [
                'success' => true,
                'token' => $token,
            ];
        }

        return [
            'success' => false,
            'message' => 'Invalid credentials',
        ];
    }

}
