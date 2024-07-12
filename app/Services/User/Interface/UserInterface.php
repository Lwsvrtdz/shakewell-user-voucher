<?php

namespace App\Services\User\Interface;

use App\Models\User;

interface UserInterface
{
    public function register(array $payload): User;

    public function login(array $payload): array;
}
