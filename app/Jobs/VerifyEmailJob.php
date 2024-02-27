<?php

namespace App\Jobs;

use App\Events\UserCreated;
use App\Exceptions\ErrorSendingEmailException;
use App\Facades\MailFacade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VerifyEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $otp;
    public function __construct($email, $otp)
    {
        $this->email = $email;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = MailFacade::createVerifyEmail($this->otp);
        if(gettype(MailFacade::sendEmail($this->email, $data)) == 'string'){
            throw new ErrorSendingEmailException(MailFacade::sendEmail($this->email, $data));
        }
    }
}
