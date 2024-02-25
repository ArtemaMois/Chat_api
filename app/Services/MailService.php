<?php

namespace App\Services;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailService
{
    public function sendEmail(string $email, array $data)
    {
        $mail = new PHPMailer(true);
        try{
            // $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = "smtp.yandex.ru";
            $mail->SMTPAuth = true;
            $mail->Username = "YaSecretChat@yandex.ru";
            $mail->Password = "mxpronixzgapumkc";
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->CharSet = "UTF-8";
            $mail->setFrom("YaSecretChat@yandex.ru", "SecretChat");
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $data['header'];
            $mail->Body = $data['body'];
            return $mail->send();
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function createEmailBody(int $otp)
    {
        return [
            'header' => 'Подтверждение электронной почты',
            'body' => view('verification.verify', ['code' => $otp])
        ];
    }
}
