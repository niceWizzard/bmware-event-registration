<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        return view('events.index', compact('events'));
    }

    public function show(string $slug)
    {
        $event = Event::whereSlug($slug)->firstOrFail();

        return view('events.show', compact('event'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'partner' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'venue' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'registration_start_date' => ['required', 'date'],
            'registration_end_date' => ['required', 'date'],
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

        $event = Event::create([
            ...$data,
            'slug' => Event::generateSlug($data['title']),
            'start_date' => Carbon::parse($data['start_date']),
            'end_date' => Carbon::parse($data['end_date']),
            'registration_start_date' => Carbon::parse($data['registration_start_date']),
            'registration_end_date' => Carbon::parse($data['registration_end_date']),
        ]);
        return Redirect::route('events.show', $event->slug);

    }

    public function create()
    {
        return view('events.create');
    }
}
