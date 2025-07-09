<?php

use App\Http\Controllers\Auth\LoginController;

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'show')
        ->name('login');
    Route::post('/login', 'store');

});
