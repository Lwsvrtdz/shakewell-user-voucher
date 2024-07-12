<?php

namespace Tests\Feature\Api\Voucher;

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function itShouldReturnVouchersByUser()
    {
        $this->setAuthenticatedUser();
        $vouchers = Voucher::factory()->count(5)->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->getJson('/api/vouchers', [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'code',
                    'created_at',
                    'updated_at',
                ],
            ]);
        $responseVouchers = $response->json();
        foreach ($vouchers as $voucher) {
            $this->assertContains($voucher->code, array_column($responseVouchers, 'code'));
        }
    }

    #[Test]
    public function itShouldReturnVoucherByCode()
    {
        $this->setAuthenticatedUser();
        $voucher = Voucher::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->json('GET', '/api/vouchers/' . $voucher->code);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $voucher->id,
                'code' => $voucher->code,
                'user_id' => $this->user->id,
                'created_at' => $voucher->created_at->toISOString(),
                'updated_at' => $voucher->updated_at->toISOString(),
            ]);

        $responseVoucher = $response->json();
        $this->assertEquals($voucher->code, $responseVoucher['code']);
    }

    #[Test]
    public function itShouldReturn404IfWrongCode()
    {
        $this->setAuthenticatedUser();
        $response = $this->getJson('/api/vouchers/wrongcode', [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(404);
    }
}
