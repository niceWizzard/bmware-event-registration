<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventManageController;
use App\Http\Controllers\EventRegistrationController;

Route::prefix('events')
    ->name('events')
    ->controller(EventController::class)
    ->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('/create', 'create')->name('.create');
            Route::post('/create', 'store')->name('.store');
            Route::get('/{short_name}/edit', 'edit')->name('.edit');
            Route::patch('/{short_name}/edit', 'update')->name('.update');
            Route::patch('/{short_name}/as-public', 'makePublic')->name('.as-public');

            Route::controller(EventManageController::class)->group(function () {
                Route::get('/{short_name}/manage', 'manage')->name('.manage');
                Route::get('/{short_name}/download', 'download')->name('.download');
            });

        });
        Route::get('/{short_name}', 'show')->name('.show');
        Route::post('/{short_name}', [EventRegistrationController::class, 'store'])->name('.register');
        Route::post('/{short_name}/clear', [EventRegistrationController::class, 'clear'])->name('.clear');
        Route::get('/{short_name}/{token}', [EventRegistrationController::class, 'showQr'])->name('.show-qr');

        Route::post('/{short_name}/delete', 'delete')->name('.delete');
        Route::get('/', 'index')->name('.index');
    });
