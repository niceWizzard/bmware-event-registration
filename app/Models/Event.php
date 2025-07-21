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
        'venue_picture',
        'partner_picture',
        'body',
        'visibility',
    ];

    protected $hidden = [
        'banner',
        'partner_picture',
        'venue_picture',
    ];

    protected $casts = [
        'registration_start_date' => 'datetime',
        'registration_end_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::deleting(static function (Event $event) {
            $files = [
                $event->banner,
                $event->venue_picture,
                $event->partner_picture,
            ];

            foreach ($files as $file) {
                if ($file && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
        });
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }

    public function canRegister(): Attribute
    {
        return Attribute::get(function (): bool {
            $now = now();
            return $this->registration_start_date->lte($now) &&
                $this->registration_end_date->gte($now);
        });
    }

    public function status(): Attribute
    {
        return Attribute::get(function (): string {
            $eventStatus = 'Pending';
            if ($this->isOngoing()) {
                $eventStatus = 'On-Going';
            } elseif ($this->end_date->isBefore(now())) {
                $eventStatus = 'Ended';
            }
            return $eventStatus;
        });
    }

    public function isOngoing(): bool
    {
        $now = now();
        return $this->start_date->lte($now) &&
            $this->end_date->gte($now);
    }

    public function isPublic(): Attribute
    {
        return Attribute::get(function (): bool {
            return $this->visibility === 'public';
        });
    }

    public function isPrivate(): Attribute
    {
        return Attribute::get(function (): bool {
            return $this->visibility === 'private';
        });
    }
}
