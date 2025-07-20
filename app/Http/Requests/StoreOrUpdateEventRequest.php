<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StoreOrUpdateEventRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true; // Set to false if you want to restrict access
    }

    public function rules(): array
    {
        $eventShortName = $this->route('short_name'); // useful for update route
        $event = null;
        if ($eventShortName) {
            $event = Event::whereShortName($eventShortName)->firstOrFail();
        }

        return [
            'title' => ['required', 'string', 'max:255'],
            'short_name' => [
                'required', 'string', 'max:72',
                Rule::unique('events', 'short_name')->ignore($event?->id),
            ],
            'partner' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'venue' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'registration_start_date' => ['required', 'date'],
            'registration_end_date' => ['required', 'date'],
            'banner' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'venue_picture' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'partner_picture' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            $regStart = Carbon::parse($this->registration_start_date);
            $regEnd = Carbon::parse($this->registration_end_date);

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
    }
}
