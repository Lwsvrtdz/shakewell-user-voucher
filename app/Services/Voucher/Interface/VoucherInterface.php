<?php

namespace App\Services\Voucher\Interface;

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Collection;

interface VoucherInterface
{
    public function getVouchersByUser(User $user): Collection;

    public function generateVoucherByUser(User $user): Voucher;

    public function getVoucherBy(string $key, string $value): ?Voucher;
}
