<?php

namespace App\Services\Voucher;

use App\Models\Voucher;
use Illuminate\Support\Str;

class GenerateVoucherCodeService
{
    /**
     * Generate a unique voucher code
     * 
     * @return string
     */
    public function generate(): string
    {
        do {
            $code = Str::random(5);
        } while ($this->codeExists($code));

        return $code;
    }

    private function codeExists(string $code): bool
    {
        return Voucher::where('code', $code)->exists();
    }
}
