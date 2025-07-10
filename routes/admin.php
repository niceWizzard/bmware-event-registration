<?php

Route::prefix('/admin')
    ->name('admin')
    ->group(function () {
        Route::get('/', static function () {
            return view('admin.dashboard');
        })->name('.dashboard');
    });
