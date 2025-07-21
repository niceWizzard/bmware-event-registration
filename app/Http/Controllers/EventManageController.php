<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Arr;

class EventManageController extends Controller
{
    public function manage(string $shortName)
    {
        $event = Event::whereShortName($shortName)->withCount([
            'registrations as male_registrations' => function ($query) {
                $query->where('gender', 'male');
            },
            'registrations as female_registrations' => function ($query) {
                $query->where('gender', 'female');
            },
            'registrations as total_registrations',
        ])->firstOrFail();

        return view('events.manage', compact('event'));
    }

    public function download(string $shortName)
    {
        $event = Event::whereShortName($shortName)->firstOrFail();

        $data = [
            'event' => Arr::except($event->toArray(), [
                'body', 'updated_at',
                'id', 'registration_start_date',
                'registration_end_date',
            ]),
        ];

        $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
        $fileName = 'event-'.$event->short_name.'-data.json';

        return \Response::make($jsonContent, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }
}
