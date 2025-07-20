<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->name('admin')
    ->group(function () {
        Route::prefix('/admin')
            ->controller(AdminController::class)
            ->group(function () {
                Route::get('/', 'index')->name('.index');
                Route::get('/create', 'create')->name('.create');
                Route::post('/store', 'store')->name('.store');
                Route::post('/delete/{id}', 'delete')->name('.delete');
            });
    });

Route::middleware('auth')
    ->prefix('/profile')
    ->controller(ProfileController::class)
    ->name('profile')
    ->group(function () {
        Route::get('/', 'index')->name('.index');
        Route::post('/info', 'updateInfo')->name('.info');
        Route::post('/email', 'updateEmail')->name('.email');
        Route::post('/password', 'updatePassword')->name('.password');
        Route::post('/delete', 'delete')->name('.delete');

    });
