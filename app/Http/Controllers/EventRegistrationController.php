<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EventRegistrationController extends Controller
{
    public function store(Request $request, string $shortName): RedirectResponse
    {
        $event = Event::whereShortName($shortName)->firstOrFail();
        if (!$event->can_register) {
            return Redirect::back()->with('error', 'Event registration already ended!');
        }
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile_number' => ['required', 'string', 'regex:/^09\d{9}$/'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'company' => ['nullable', 'string', 'max:255'],
        ], [
            'mobile_number.regex' => 'Invalid mobile number',
        ]);
        $data['gender'] = Str::lower($data['gender']);
        $registration = EventRegistration::create([
            ...$data,
            'event_id' => $event->id,
        ]);
        Cookie::queue(
            Cookie::make('event_' . $event->id, $registration->token, 60 * 24 * 7)
        );

        return Redirect::route('events.show-qr', [$event->short_name, $registration->token]);
    }

    public function showQr(string $shortName, string $token)
    {
        $event = Event::whereShortName($shortName)->firstOrFail();
        $registration = EventRegistration::whereToken($token)->firstOrFail()->attributesToArray();
        $qrCodeData = [
            'short_name' => $event->short_name,
            ...$registration,
        ];

        return view('events.qr', compact('event', 'qrCodeData'));
    }

    public function clear(string $shortName)
    {
        $event = Event::whereShortName($shortName)->firstOrFail();
        $registrationCookie = Cookie::get('event_' . $event->id);
        if (is_null($registrationCookie)) {
            return back()->with([
                'message' => 'Registration cookie not found.',
            ]);
        }
        Cookie::queue(
            Cookie::forget('event_' . $event->id)
        );

        $previousUrl = url()->previous();

        if (!str_contains($previousUrl, '#register')) {
            $previousUrl .= '#register';
        }

        return redirect()->to($previousUrl);
    }
}
