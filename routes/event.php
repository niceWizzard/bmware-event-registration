<?php

use App\Http\Controllers\EventController;

Route::prefix('events')
    ->name('events')
    ->controller(EventController::class)
    ->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('/create', 'create')->name('.create');
            Route::post('/create', 'store')->name('.store');
        });
        Route::get('/{slug}', 'show')->name('.show');
        Route::get('/', 'index')->name('.index');
    });
