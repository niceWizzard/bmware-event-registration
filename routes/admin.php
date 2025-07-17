<?php

use App\Models\Event;

Route::prefix('/admin')
    ->name('admin')
    ->group(function () {
        Route::get('/', static function () {
            $events = Event::withCount('registrations')->get();

            return view('admin.dashboard', [
                'events' => $events,
            ]);
        })->name('.dashboard');
    });
