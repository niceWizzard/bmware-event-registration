<?php

use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
});

require __DIR__.'/auth.php';
require __DIR__.'/event.php';
require __DIR__.'/admin.php';
