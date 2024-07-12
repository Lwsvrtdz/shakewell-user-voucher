<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $user;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();


        $this->user = User::factory()->create(['password' => 'test12345']);
    }

    protected function setAuthenticatedUser()
    {
        $response = $this->postJson('/api/users/login', [
            'username' => $this->user->username,
            'password' => 'test12345',
        ]);
    }

    protected function setHeaders(string $token): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ];
    }
}
