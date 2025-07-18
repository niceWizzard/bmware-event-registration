<?php

use App\Http\Controllers\AdminController;
use App\Models\Event;

Route::middleware('auth')
    ->name('admin')
    ->group(function () {
        Route::get('/dashboard', static function () {
            $events = Event::withCount('registrations')
                ->orderByDesc('start_date')      // latest start_date first
                ->orderBy('updated_at')      // if same start_date, latest created first
                ->paginate(12);

            return view('admin.dashboard', [
                'events' => $events,
            ]);
        })->name('.dashboard');

        Route::prefix('/admin')
            ->controller(AdminController::class)
            ->group(function () {
                Route::get('/', 'index')->name('.index');
                Route::get('/create', 'create')->name('.create');
                Route::post('/store', 'store')->name('.store');
                Route::post('/delete/{id}', 'delete')->name('.delete');
            });
    });
