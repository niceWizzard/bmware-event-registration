<?php

use App\Http\Controllers\Auth\LoginController;

Route::controller(LoginController::class)
    ->middleware(['guest'])
    ->group(function () {
        Route::get('/login', 'show')
            ->name('login');
        Route::post('/login', 'store');

        Route::post('/logout', 'destroy')
            ->name('logout')
            ->middleware('auth')
            ->withoutMiddleware(['guest']);

    });
