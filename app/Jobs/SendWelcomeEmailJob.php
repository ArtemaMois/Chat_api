<?php

namespace App\Jobs;

use App\Exceptions\ErrorSendingEmailException;
use App\Facades\MailFacade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = MailFacade::createWelcomeEmail();
        if(gettype(MailFacade::sendEmail($this->email, $data)) == 'string'){
            throw new ErrorSendingEmailException(MailFacade::sendEmail($this->email, $data));
        }
    }
}
