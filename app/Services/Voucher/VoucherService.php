<?php

namespace App\Services\Voucher;

use App\Models\User;
use App\Models\Voucher;
use App\Services\Voucher\Interface\VoucherInterface;
use Illuminate\Database\Eloquent\Collection;

class VoucherService implements VoucherInterface
{
    public function __construct(
        protected VoucherLimitService $voucherLimitService,
        protected GenerateVoucherCodeService $generateVoucherCodeService,
        protected GenerateVoucherService $generateVoucherService
    ) {
    }

    /**
     * Get vouchers
     *
     * @param User $user
     * @return Collection
     */
    public function getVouchersByUser(User $user): Collection
    {
        return $user->vouchers;
    }

    /**
     * Generate voucher by users
     *
     * @param User $user
     * @return Voucher
     */
    public function generateVoucherByUser(User $user): Voucher
    {
        if ($this->voucherLimitService->hasExceedLimit($user)) {
            abort(response()->json(['error' => 'Voucher limit exceeded'], 400));
        }

        return $this->generateVoucherService->make([
            'user_id' => $user->id,
            'code' => $this->generateVoucherCodeService->generate(),
        ]);
    }

    public function getVoucherBy(string $key, string $value): ?Voucher
    {
        return Voucher::where($key, $value)->firstOrFail();
    }
}
