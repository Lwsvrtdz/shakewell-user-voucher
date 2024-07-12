<?php

namespace App\Services\Voucher;

use App\Models\User;
use App\Models\Voucher;

class VoucherLimitService
{
    private const MAX_VOUCHERS_PER_USER = 3;

    public function hasExceedLimit(User $user): bool
    {
        return $user->vouchers()->count() >= self::MAX_VOUCHERS_PER_USER;
    }
}
