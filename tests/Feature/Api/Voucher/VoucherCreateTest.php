<?php

namespace Tests\Feature\Api\Voucher;

use App\Models\User;
use App\Models\Voucher;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class VoucherCreateTest extends TestCase
{
    use RefreshDatabase;

    public function itShouldUnauthorizedIfNotLoggedIn()
    {
        $response = $this->postJson('/api/vouchers/generate');

        $response->assertStatus(401);
    }

    #[Test]
    public function itShouldGenerateVoucher()
    {
        $this->setAuthenticatedUser();
        $response = $this->postJson('/api/vouchers/generate', [], [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ]);

        $voucherJson = $response->json('voucher');

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Voucher generated successfully.',
            'voucher' => $voucherJson
        ]);
    }

    #[Test]
    public function itShouldNotGenerateIfItExceedsLimit()
    {
        $this->setAuthenticatedUser();
        $vouchers = Voucher::factory()->count(10)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->postJson(
            '/api/vouchers/generate',
            [],
            [
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
            ]
        );
        $response->assertStatus(400)
            ->assertJsonStructure([
                'error'
            ]);
        $response->assertJson([
            'error' => 'Voucher limit exceeded'
        ]);
    }
}
