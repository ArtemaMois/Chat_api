<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;


// /**
//  * @method void|string sendEmail(string $email, int $otp)
//  */
class MailFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mail_service';
    }
}
