<?php

use App\Http\Controllers\EventController;

Route::prefix('events')
    ->name('events')
    ->controller(EventController::class)
    ->group(function () {
        Route::get('/', 'index')->name('.index');
        Route::get('/{slug}', 'show')->name('.show');
    });
