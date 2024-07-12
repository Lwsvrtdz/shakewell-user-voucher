<?php

namespace Tests\Feature\Api\Voucher;

use Tests\TestCase;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class VoucherDeleteTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function itShouldUnauthorizedIfNotLoggedIn()
    {
        $response = $this->deleteJson(route('vouchers.destroy', 1));

        $response->assertStatus(401);
    }

    #[Test]
    public function itShouldUnauthorizedIfNotLoggedInByCode()
    {
        $response = $this->deleteJson(route('vouchers.destroy.code', 1));

        $response->assertStatus(401);
    }

    #[Test]
    public function itShouldReturn403IfUserIsNotOwnerOfTheVoucher()
    {
        $this->setAuthenticatedUser();
        $voucher = Voucher::factory()->create([
            'user_id' => '55112'
        ]);

        $response = $this->withHeaders(
            $this->setHeaders('wrong-token')
        )
            ->deleteJson(route('vouchers.destroy', $voucher->id));

        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'Unauthorized'
        ]);
    }

    #[Test]
    public function itShouldSuccessFullyDeleteVoucherUsingId()
    {
        $this->setAuthenticatedUser();
        $voucher = Voucher::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->deleteJson(route('vouchers.destroy', $voucher->id));

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Voucher deleted successfully.'
        ]);
    }

    #[Test]
    public function itShouldReturn404IfVoucherNotFound()
    {
        $this->setAuthenticatedUser();
        $response = $this->deleteJson(route('vouchers.destroy', 123));

        $response->assertStatus(404);
    }

    public function itShouldSuccessFullyDeleteVoucherUsingCode()
    {
        $this->setAuthenticatedUser();
        $voucher = Voucher::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->deleteJson(route('vouchers.destroy.code', $voucher->code));

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Voucher deleted successfully.'
        ]);
    }

    public function itShouldReturn404IfVoucherNotFoundByCode()
    {
        $this->setAuthenticatedUser();
        $response = $this->deleteJson(route('vouchers.destroy.code', '123'));

        $response->assertStatus(404);
    }
}
