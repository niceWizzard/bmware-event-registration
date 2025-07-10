<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EventRegistrationController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $event = Event::whereSlug($slug)->firstOrFail();
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile_number' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'company' => ['string', 'max:255'],
        ]);

        $registration = EventRegistration::create([
            ...$data,
            'event_id' => $event->id,
        ]);
        return Redirect::route('events.show-qr', [$event->slug, $registration->id]);
    }

    public function showQr(string $slug, string $registrationId)
    {
        $event = Event::whereSlug($slug)->firstOrFail();
        $registration = EventRegistration::findOrFail($registrationId)->attributesToArray();

        return view('events.qr', compact('event', 'registration'));
    }
}
