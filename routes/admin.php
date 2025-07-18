<?php

use App\Models\Event;

Route::prefix('/admin')
    ->name('admin')
    ->group(function () {
        Route::get('/', static function () {
            $events = Event::withCount('registrations')
                ->orderByDesc('start_date')      // latest start_date first
                ->orderBy('updated_at')      // if same start_date, latest created first
                ->get();

            return view('admin.dashboard', [
                'events' => $events,
            ]);
        })->name('.dashboard');
    });
