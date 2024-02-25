<?php

use App\Http\Controllers\Api\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(MailController::class)->middleware('guest')->group(function() {
});

