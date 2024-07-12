<?php

namespace App\Services\Voucher;

use App\Models\Voucher;

class GenerateVoucherService
{
    public function make(array $payload): Voucher
    {
        return Voucher::create($payload);
    }
}
