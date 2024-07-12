<?php

namespace Database\Factories;

use App\Services\Voucher\GenerateVoucherCodeService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $generateVoucherCode = new GenerateVoucherCodeService();

        return [
            'code' => $generateVoucherCode->generate(),
        ];
    }
}
