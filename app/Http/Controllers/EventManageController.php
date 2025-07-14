<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;

class EventManageController extends Controller
{
    public function manage(string $shortName)
    {
        $event = Event::whereShortName($shortName)->firstOrFail();

        return view('events.manage', compact('event'));
    }

    public function download(string $shortName)
    {
        $event = Event::whereShortName($shortName)->firstOrFail();

        $data = [
            'event' => $event->toArray(),
            'registrations' => $event->registrations->map(fn(EventRegistration $registration) => [
                'first_name' => $registration->first_name,
                'last_name' => $registration->last_name,
                'email' => $registration->email,
                'mobile_number' => $registration->mobile_number,
                'gender' => $registration->gender,
                'company' => $registration->company,
                'short_name' => $event->short_name,
            ])->toArray(),
        ];

        $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
        $fileName = 'resource.json';

        return \Response::make($jsonContent, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }
}
