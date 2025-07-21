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
        $event = Event::whereShortName($shortName)
            ->where('visibility', 'public')
            ->firstOrFail();
        if (! $event->can_register) {
            return Redirect::back()->with('error', 'Event registration already ended!');
        }
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile_number' => ['required', 'string', 'regex:/^09\d{9}$/'],
            'gender' => ['required', Rule::in(['male', 'female'])],
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
            Cookie::make('event_'.$event->id, $registration->token, 60 * 24 * 7)
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
        $registrationCookie = Cookie::get('event_'.$event->id);
        if (is_null($registrationCookie)) {
            return back()->with([
                'message' => 'Registration cookie not found.',
            ]);
        }
        Cookie::queue(
            Cookie::forget('event_'.$event->id)
        );

        $previousUrl = url()->previous();

        if (! str_contains($previousUrl, '#register')) {
            $previousUrl .= '#register';
        }

        return redirect()->to($previousUrl);
    }

    public function show(string $shortName, Request $request)
    {
        $event = Event::whereShortName($shortName)
            ->withCount('registrations')
            ->firstOrFail();

        $search = $request->input('search');
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        $allowedSorts = ['first_name', 'last_name', 'email', 'mobile_number', 'company', 'created_at'];
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        $registrationsQuery = $event->registrations();

        if ($search) {
            $registrationsQuery->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('mobile_number', 'like', "%{$search}%");
            });
        }

        $registrations = $registrationsQuery
            ->orderBy($sort, $direction)
            ->paginate(24)
            ->withQueryString();

        return view('events.registrations.show', compact('event', 'registrations'));
    }
}
