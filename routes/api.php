<?php

use App\Http\Controllers\Auth\OauthController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/{idp}/callback', [OauthController::class, 'callback'])
    ->name('auth.callback');
