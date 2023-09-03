<?php

use App\Http\Controllers\Auth\OauthController;
use App\Http\Controllers\StreamingEvents\EventsAggregateController;
use App\Http\Controllers\StreamingEvents\ReadStateController;
use App\Http\Controllers\StreamingEvents\RevenueController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/{idp}/callback', [OauthController::class, 'callback'])
    ->name('auth.callback');

// TODO: protect with sanctum
Route::put('/streaming-events/{streaming_event_type}/{id}/{action}', ReadStateController::class);

Route::get('/streaming-events', EventsAggregateController::class);
Route::get('/streaming-events/revenue', RevenueController::class);
