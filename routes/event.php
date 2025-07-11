<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;

Route::prefix('events')
    ->name('events')
    ->controller(EventController::class)
    ->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('/create', 'create')->name('.create');
            Route::post('/create', 'store')->name('.store');
        });
        Route::get('/{slug}', 'show')->name('.show');
        Route::post('/{slug}', [EventRegistrationController::class, 'store'])->name('.register');
        Route::get('/{slug}/{token}', [EventRegistrationController::class, 'showQr'])->name('.show-qr');
        Route::get('/', 'index')->name('.index');
    });
