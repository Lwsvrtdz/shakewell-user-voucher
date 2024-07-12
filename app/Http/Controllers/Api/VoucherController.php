<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckVoucherDeletion;
use App\Http\Resources\VoucherResource;
use App\Http\Resources\VoucherResourceCollection;
use App\Models\User;
use App\Models\Voucher;
use App\Services\Voucher\Interface\VoucherInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class VoucherController extends Controller implements HasMiddleware
{
    protected VoucherInterface $voucherService;

    public static function middleware(): array
    {
        return [
            new Middleware(CheckVoucherDeletion::class, ['only' => 'destroy'])
        ];
    }

    public function __construct(VoucherInterface $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    /**
     * Get vouchers by user
     *
     * @param User $user
     * @return VoucherResourceCollection
     */
    public function getVouchersByUser(User $user): VoucherResourceCollection
    {
        $user = auth()->user();
        $vouchers = $this->voucherService->getVouchersByUser($user);

        return (new VoucherResourceCollection($vouchers));
    }

    /**
     * Generate voucher by user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function generateVoucher(Request $request): JsonResponse
    {
        $voucher = $this->voucherService->generateVoucherByUser(auth()->user());

        return response()->json(['message' => 'Voucher generated successfully.', 'voucher' => $voucher]);
    }

    /**
     * Get voucher by code
     *
     * @param string $voucherCode
     * @return VoucherResource
     */
    public function show(string $voucherCode): VoucherResource
    {
        $voucher = $this->voucherService->getVoucherBy('code', $voucherCode);

        return (new VoucherResource($voucher));
    }

    /**
     * Delete voucher by id
     *
     * @param Voucher $voucher
     * @return JsonResponse
     */
    public function destroy(Voucher $voucher): JsonResponse
    {
        $voucher->delete();

        return response()->json(['message' => 'Voucher deleted successfully.']);
    }

    /**
     * Delete voucher by code
     *
     * @param string $voucherCode
     * @return JsonResponse
     */
    public function destroyByCode(string $voucherCode): JsonResponse
    {
        $voucher = $this->voucherService->getVoucherBy('code', $voucherCode);

        $voucher->delete();

        return response()->json(['message' => 'Voucher deleted successfully.']);
    }
}
