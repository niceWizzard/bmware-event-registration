<?php

use App\Models\Event;

Route::prefix('/admin')
    ->name('admin')
    ->group(function () {
        Route::get('/', static function () {
            $events = Event::all();

            return view('admin.dashboard', [
                'events' => $events,
            ]);
        })->name('.dashboard');
    });
