<?php

use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    $upcomingEvents = \App\Models\Event::withCount('registrations')
        ->where('start_date', '>=', now())
        ->orderBy('registrations_count', 'desc')
        ->limit(5)
        ->get();

    return view('welcome', compact('upcomingEvents'));
})->name('home');

require __DIR__ . '/auth.php';
require __DIR__ . '/event.php';
require __DIR__ . '/admin.php';
