<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'short_name',
        'description',
        'venue',
        'partner',
        'start_date',
        'end_date',
        'banner',
        'registration_start_date',
        'registration_end_date',
    ];

    protected $hidden = [
        'banner',
    ];

    protected $casts = [
        'registration_start_date' => 'datetime',
        'registration_end_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $appends = [
        'banner_url',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }

    public function bannerUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return Storage::disk('public')->url($this->banner);
        });
    }

    public function canRegister(): Attribute
    {
        return Attribute::get(function (): bool {
            return $this->start_date->isAfter(now()) &&
                $this->registration_end_date->isBefore(now());
        });
    }

    public function status(): Attribute
    {
        return Attribute::get(function (): string {
            $eventOnGoing = $this->start_date->isAfter(now());

            $eventStatus = 'Pending';
            if ($eventOnGoing && $this->end_date->isBefore(now())) {
                $eventStatus = 'On-Going';
            } else {
                $eventStatus = 'Ended';
            }
            return $eventStatus;
        });
    }

}
