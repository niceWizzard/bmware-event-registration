<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ForgotPasswordController;

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

        Route::controller(ForgotPasswordController::class)->group(function () {
            Route::get('forgot-password', 'show')
                ->name('password.request');
            Route::post('forgot-password', 'sendEmail')
                ->name('password.email');

            Route::get('reset-password/{token}', 'showResetLink')
                ->name('password.reset');

            Route::post('reset-password',  'resetPassword')
                ->name('password.store');
        });
    });
