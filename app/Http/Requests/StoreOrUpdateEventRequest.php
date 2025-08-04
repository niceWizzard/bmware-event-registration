<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StoreOrUpdateEventRequest extends FormRequest
{

    const REGEX_SHORT_STRING = 'regex:/^[A-Za-z0-9\s\-\!\?\.\,\']+$/';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $eventShortName = $this->route('short_name'); // useful for update route
        $event = null;
        if ($eventShortName) {
            $event = Event::whereShortName($eventShortName)->firstOrFail();
        }

        return [
            'title' => ['required', 'string', 'max:255', self::REGEX_SHORT_STRING,],
            'visibility' => ['required', Rule::in(['public', 'private'])],
            'short_name' => [
                'required', 'string', 'max:72',
                'regex:/^[A-Za-z0-9_-]+$/',
                Rule::unique('events', 'short_name')->ignore($event?->id),
            ],
            'partner' => ['required', 'string', 'max:255', self::REGEX_SHORT_STRING],
            'description' => ['required', 'string', 'max:255', self::REGEX_SHORT_STRING,],
            'body' => ['required', 'string',],
            'venue' => ['required', 'string', self::REGEX_SHORT_STRING],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'registration_start_date' => ['required', 'date'],
            'registration_end_date' => ['required', 'date'],
            'banner' => ['nullable', Rule::imageFile(), 'max:2048'],
            'venue_picture' => ['nullable', Rule::imageFile(), 'max:2048'],
            'partner_picture' => ['nullable', Rule::imageFile(), 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'short_name.regex' => 'The short name may only contain letters, numbers, hyphens, and underscores.',
            '*.regex' => 'Only special characters allowed are (!, @, #)',
            'venue_picture.max' => 'Maximum of 2 MB pictures.',
            'banner.max' => 'Maximum of 2 MB pictures.',
            'partner_picture.max' => 'Maximum of 2 MB pictures.',
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
