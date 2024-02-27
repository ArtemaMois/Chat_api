<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Exceptions\ErrorSendingEmailException;
use App\Facades\MailFacade;
use App\Jobs\SendWelcomeEmailJob;
use App\Jobs\VerifyEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Testing\Fakes\MailFake;

class UserEmailNotification
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
    public function handle(UserCreated $event): void
    {
        dispatch(new SendWelcomeEmailJob($event->email));
    }
}
