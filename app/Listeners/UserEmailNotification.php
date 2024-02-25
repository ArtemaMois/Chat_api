<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Exceptions\ErrorSendingEmailException;
use App\Facades\MailFacade;
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
        $data = MailFacade::createEmailBody($event->otp);
        if(gettype(MailFacade::sendEmail($event->email, $data)) == 'string'){
            throw new ErrorSendingEmailException(MailFacade::sendEmail($event->email, $data));
        }
    }
}
