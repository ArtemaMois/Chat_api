<?php

namespace App\Http\Controllers\Api;

use App\Facades\Mail;
use App\Facades\MailFacade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{


    public function sendEmail(string $email, array $data)
    {
        return MailFacade::sendEmail($email, $data);
    }
}
