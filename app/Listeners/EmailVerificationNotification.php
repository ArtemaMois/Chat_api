<?php

namespace App\Listeners;

use App\Events\VerifyEmail;
use App\Jobs\VerifyEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailVerificationNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VerifyEmail $event): void
    {
        dispatch(new VerifyEmailJob($event->email, $event->otp));
    }
}
