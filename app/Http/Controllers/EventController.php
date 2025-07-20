<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $sortField = request('sort', 'start_date'); // default to start_date
        $sortOrder = request('order', 'desc');      // default to descending
        $visibility = request('visibility');
        $status = request('status'); // Expecting: Pending, On-Going, Ended




        // Allowed fields that map directly to DB or computed values
        $allowedFields = [
            'start_date',
            'registration_start_date',
            'registrations',
            'updated_at',
            'created_at',
        ];

        $allowedOrders = ['asc', 'desc'];

        // Validate
        if (!in_array($sortField, $allowedFields)) {
            $sortField = 'start_date';
        }

        if (!in_array($sortOrder, $allowedOrders)) {
            $sortOrder = 'desc';
        }

        $query = Event::withCount('registrations');

        if (in_array($status, ['Pending', 'On-Going', 'Ended'])) {
            $now = now();

            if ($status === 'Pending') {
                $query->where('start_date', '>', $now);
            } elseif ($status === 'On-Going') {
                $query->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now);
            } elseif ($status === 'Ended') {
                $query->where('end_date', '<', $now);
            }
        }

        if ($sortField === 'registrations') {
            $query->orderBy('registrations_count', $sortOrder);
        } else {
            $query->orderBy($sortField, $sortOrder);
        }

        // Secondary sort (e.g., updated_at desc)
        $query->orderBy('updated_at', 'desc');

        if ($visibility) {
            $query->where('visibility', $visibility);
        } elseif (!Auth::check()) {
            // For guests: default to only public
            $query->where('visibility', 'public');
        }



        $events = $query->paginate(12)->withQueryString();

        return view('events.index', compact('events'));
    }



    public function show(string $shortName)
    {
        $query = Event::whereShortName($shortName);

        if (!Auth::check()) {
            $query->where('visibility', 'public');
        }
        $event = $query->firstOrFail();

        return view('events.show', compact('event'));
    }

    public function edit(Request $request, string $shortName)
    {
        $event = Event::whereShortName($shortName)->firstOrFail();

        return view('events.edit', compact('event'));
    }

    public function makePublic(string $shortName)
     {
         $event = Event::whereShortName($shortName)->firstOrFail();
         $event->visibility = 'public';
         $event->save();
         return Redirect::route('events.show', [$shortName]);
     }
    public function update(string $shortName, StoreOrUpdateEventRequest $request)
    {
        $event = Event::whereShortName($shortName)->firstOrFail();
        $data = $request->validated();
        $data['banner'] = $this->updateFile(
            $request,
            $event->banner,
            'banner',
            'clear_banner',
            'banners',
        );

        $data['partner_picture'] = $this->updateFile(
            $request,
            $event->partner_picture,
            'partner_picture',
            'clear_partner_picture',
            'pictures'
        );

        $data['venue_picture'] = $this->updateFile(
            $request,
            $event->venue_picture,
            'venue_picture',
            'clear_venue_picture',
            'pictures'
        );

        $event->update($data);

        return Redirect::route('events.show', $event->short_name);
    }

    public function updateFile(
        Request $request,
        ?string $existingPath,
        string  $fileName,
        string  $clearName,
        string  $fileLocation
    ): ?string
    {
        $shouldClear = $request->boolean($clearName);
        $hasNewFile = $request->hasFile($fileName);

        if ($shouldClear) {
            if ($existingPath && Storage::disk('public')->exists($existingPath)) {
                Storage::disk('public')->delete($existingPath);
            }

            return null;
        }
        // If a new file is uploaded (and not marked for clearing), replace it
        if ($hasNewFile) {
            if ($existingPath && Storage::disk('public')->exists($existingPath)) {
                Storage::disk('public')->delete($existingPath);
            }

            return Storage::disk('public')->put($fileLocation, $request->file($fileName));
        }

        return $existingPath;
    }

    public function delete(string $shortName)
    {
        $event = Event::whereShortName($shortName)->firstOrFail();
        $event->delete();
        return Redirect::route('events.index');
    }

    public function store(StoreOrUpdateEventRequest $request)
    {
        $data = $request->validated();
        if (isset($data['banner']) && $data['banner']) {
            $data['banner'] = $request->file('banner')
                ->store('banners', 'public');
        }
        if (isset($data['venue_picture']) && $data['venue_picture']) {
            $data['venue_picture'] = $request->file('venue_picture')
                ->store('pictures', 'public');
        }
        if (isset($data['partner_picture']) && $data['partner_picture']) {
            $data['partner_picture'] = $request->file('partner_picture')
                ->store('pictures', 'public');
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
