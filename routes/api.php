<?php

use App\Http\Controllers\Auth\OauthController;
use App\Http\Controllers\StreamingEvents\EventsAggregateController;
use App\Http\Controllers\StreamingEvents\ReadStateController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/{idp}/callback', [OauthController::class, 'callback'])
    ->name('auth.callback');

// TODO: protect with sanctum
Route::put('/streaming-events/{streaming_event_type}/{id}/read', [ReadStateController::class, 'read']);
Route::put('/streaming-events/{streaming_event_type}/{id}/unread', [ReadStateController::class, 'unread']);

Route::get('/streaming-events', EventsAggregateController::class);
