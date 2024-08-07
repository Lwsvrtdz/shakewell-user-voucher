<?php

use App\Http\Controllers\Api\VoucherController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'vouchers', 'as' => 'vouchers.'], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('', [VoucherController::class, 'getVouchersByUser'])->name('index');
        Route::post('/generate', [VoucherController::class, 'generateVoucher'])->name('generate');
        Route::get('{value}/{key}', [VoucherController::class, 'show'])->name('show');
        Route::delete('{voucher}', [VoucherController::class, 'destroy'])->name('destroy');
        Route::delete('{voucherCode}/code', [VoucherController::class, 'destroyByCode'])->name('destroy.code');
    });
});
