<?php

namespace Tests\Feature\Api\User;

use App\Mail\WelcomeVoucherEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    private const USER_DATA = [
        'username' => 'test',
        'name' => 'test',
        'email' => 'test@test.com',
        'password' => 'test12345',
    ];

    private const API_URL = '/api/users/';

    #[Test]
    public function registerInvalidDataShouldReturn422()
    {
        $response = $this->postJson(self::API_URL . 'register', []);
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'username' => ['The username field is required.'],
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ],
            ]);
    }

    #[Test]
    public function itShouldRegisterUser()
    {
        $response = $this->postJson(self::API_URL . 'register', self::USER_DATA);

        $response->assertStatus(201);
    }

    #[Test]
    public function itShouldGenerateANewVoucher()
    {
        $response = $this->postJson(self::API_URL . 'register', self::USER_DATA);
        $response->assertStatus(201);
        $user = User::where('email', self::USER_DATA['email'])->first();
        $this->assertNotNull($user->vouchers()->first());
    }

    #[Test]
    public function itShouldSendAnWelcomeVoucherEmail()
    {
        Mail::fake();

        $response = $this->postJson(self::API_URL . 'register', self::USER_DATA);
        $response->assertStatus(201);

        Mail::assertSent(WelcomeVoucherEmail::class, function ($mail) {
            return $mail->hasTo(self::USER_DATA['email']);
        });
    }
}
