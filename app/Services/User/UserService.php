<?php

namespace App\Services\User;

use App\Events\UserRegistered;
use App\Models\User;
use App\Services\User\Interface\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserService implements UserInterface
{
    /**
     * Register a new user.
     *
     * @param  array  $payload
     * @return User
     */
    public function register(array $payload): User
    {
        $user = User::create($payload);

        UserRegistered::dispatch($user);

        return $user;
    }

    /**
     * Login a user.
     *
     * @param  array  $payload
     * @return array
     */
    public function login(array $payload): array
    {

        if (false === Auth::attempt($payload)) {
            throw new HttpException(401, 'Invalid credentials');
        }

        $user = auth()->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;
        return [
            'accessToken' => $token,
            'token_type' => 'Bearer'
        ];
    }
}
