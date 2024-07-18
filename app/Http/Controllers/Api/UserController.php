<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\User\Interface\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register a new user.
     * 
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \App\Http\Resources\UserResource
     */
    public function register(UserRequest $request)
    {
        $user = $this->userService->register($request->validated());

        return (new UserResource($user));
    }

    /**
     * Login a user.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $data = $this->userService->login($request->validated());

        return response()->json($data);
    }
}
