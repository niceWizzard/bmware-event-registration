<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
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
        Cookie::queue(
            Cookie::make('event_' . $event->id, $registration->token, 60 * 24 * 7)
        );

        return Redirect::route('events.show-qr', [$event->slug, $registration->token]);
    }

    public function showQr(string $slug, string $token)
    {
        $event = Event::whereSlug($slug)->firstOrFail();
        $registration = EventRegistration::whereToken($token)->firstOrFail()->attributesToArray();
        $qrCodeData = [
            'slug' => $event->slug,
            ...$registration,
        ];
        return view('events.qr', compact('event', 'qrCodeData'));
    }

    public function clear(string $slug)
    {
        $event = Event::whereSlug($slug)->firstOrFail();
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
