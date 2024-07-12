<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\WelcomeVoucherEmail;
use App\Services\Voucher\GenerateVoucherCodeService;
use App\Services\Voucher\GenerateVoucherService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UserRegisteredListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly GenerateVoucherCodeService $generateVoucherCodeService,
        private readonly GenerateVoucherService $generateVoucherService
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {

        $user = $event->user;

        $voucherCode = $this->generateVoucherCodeService->generate();

        $this->generateVoucherService->make([
            'user_id' => $user->id,
            'code' => $voucherCode,
        ]);

        Mail::to($user->email)->send(new WelcomeVoucherEmail($user, $voucherCode));
    }
}
