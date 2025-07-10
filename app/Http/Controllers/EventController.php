<?php

namespace App\Http\Controllers;

use App\Models\Event;

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

}
