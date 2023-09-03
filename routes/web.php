<?php

use App\Http\Controllers\Auth\OauthController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/{idp}/redirect', [OauthController::class, 'redirect'])
    ->name('auth.redirect');

Route::get('/{path}', fn () => view('app'))
    ->where('path', '(?!api).*');
