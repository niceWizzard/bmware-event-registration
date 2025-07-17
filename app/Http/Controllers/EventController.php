<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withCount('registrations')->get();

        return view('events.index', compact('events'));
    }

    public function show(string $shortName)
    {
        $event = Event::whereShortName($shortName)->firstOrFail();

        return view('events.show', compact('event'));
    }

    public function edit(Request $request, string $shortName)
    {
        $event = Event::whereShortName($shortName)->firstOrFail();

        return view('events.edit', compact('event'));
    }

    public function update(string $shortName, Request $request)
    {
        $event = Event::whereShortName($shortName)->firstOrFail();
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'short_name' => [
                'required', 'string', 'max:72',
                Rule::unique('events', 'short_name')->ignore($event->id),
            ],
            'partner' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'venue' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'registration_start_date' => ['required', 'date'],
            'registration_end_date' => ['required', 'date'],
            'event_banner' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'clear_banner' => ['sometimes'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);
            $regStart = Carbon::parse($request->registration_start_date);
            $regEnd = Carbon::parse($request->registration_end_date);

            if ($start->isAfter($end)) {
                $validator->errors()->add('start_date', 'The start date must not be after the end date.');
            }

            if ($regStart->isAfter($regEnd)) {
                $validator->errors()->add('registration_start_date', 'The registration start date must not be after the registration end date.');
            }

            if ($regEnd->isAfter($start)) {
                $validator->errors()->add('registration_end_date', 'Registration must end before the event starts.');
            }
            if ($start->equalTo($end)) {
                $validator->errors()->add('end_date', 'The end date must be after the start date.');
            }
        });

        $validator->validate();

        $data = $validator->validated();
        if ($request->hasFile('event_banner') && !$request->boolean('clear_banner')) {
            if ($event->banner && Storage::disk('public')->exists($event->banner)) {
                Storage::disk('public')->delete($event->banner);
            }

            $data['banner'] = $request->file('event_banner')->store('banners', 'public');
        } else if ($request->boolean('clear_banner')) {
            if ($event->banner && Storage::disk('public')->exists($event->banner)) {
                Storage::disk('public')->delete($event->banner);
            }
            $event->banner = null;
            $event->save();
        }

        $event->update($data);
        return Redirect::route('events.show', $event->short_name);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'short_name' => ['required', 'string', 'max:72', Rule::unique('events', 'short_name')],
            'partner' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'venue' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'registration_start_date' => ['required', 'date'],
            'registration_end_date' => ['required', 'date'],
            'event_banner' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);
            $regStart = Carbon::parse($request->registration_start_date);
            $regEnd = Carbon::parse($request->registration_end_date);

            if ($start->isAfter($end)) {
                $validator->errors()->add('start_date', 'The start date must not be after the end date.');
            }

            if ($regStart->isAfter($regEnd)) {
                $validator->errors()->add('registration_start_date', 'The registration start date must not be after the registration end date.');
            }

            if ($regEnd->isAfter($start)) {
                $validator->errors()->add('registration_end_date', 'Registration must end before the event starts.');
            }
            if ($start->equalTo($end)) {
                $validator->errors()->add('end_date', 'The end date must be after the start date.');
            }
        });

        $validator->validate();

        $data = $validator->validated();
        if (isset($data['event_banner']) && $data['event_banner']) {
            $data['banner'] = $request->file('event_banner')
                ->store('banners', 'public');
        }

        $event = Event::create([
            ...$data,
            'start_date' => Carbon::parse($data['start_date']),
            'end_date' => Carbon::parse($data['end_date']),
            'registration_start_date' => Carbon::parse($data['registration_start_date']),
            'registration_end_date' => Carbon::parse($data['registration_end_date']),
        ]);

        return Redirect::route('events.show', $event->short_name);

    }

    public function create()
    {
        return view('events.create');
    }
}
