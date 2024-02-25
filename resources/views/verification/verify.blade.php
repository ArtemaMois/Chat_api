<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
    @vite(['/resources/css/email.css'])
</head>
<body>
    <main>
        <p class="email-verification__header">Спасибо, что используете наш мессенджер!</p>
        <div class="email-verification__body">
            <p class="email-verification__text">Ваш код для подтвеждения электронной почты:</p>
            <p class="email-verification__code">{{ $code }}</p>
        </div>
    </main>
</body>
</html>
