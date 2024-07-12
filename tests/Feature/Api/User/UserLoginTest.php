<?php

namespace Tests\Feature\Api\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    private const API_URL = '/api/users/login';

    private const USER_CREDS = [
        'username' => 'test',
        'password' => 'test12345',
    ];

    #[Test]
    public function returns422ForInvalidData()
    {
        $response = $this->postJson(self::API_URL, []);
        $response->assertStatus(422);
    }

    #[Test]
    public function itShouldLogin()
    {
        $userData = self::USER_CREDS;
        $userData['name'] = 'test';
        $userData['email'] = 'test@test.com';
        $user = User::create($userData);
        $response = $this->postJson(self::API_URL, self::USER_CREDS);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'accessToken',
                'token_type'
            ]);
    }

    #[Test]
    public function itShouldReturn401IfWrongCredentials()
    {
        $response = $this->postJson(self::API_URL, ['username' => 'wrong', 'password' => 'wrong123']);

        $response->assertStatus(401);
    }
}
