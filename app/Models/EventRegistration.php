<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    /** @use HasFactory<\Database\Factories\EventRegistrationFactory> */
    use HasFactory;

    protected $fillable = [
        'event_id',
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'company',
        'gender',
    ];

    protected $appends = [
        'slug',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function slug(): Attribute
    {
        return Attribute::get(function (): string {
            return $this->event->slug;
        });
    }
}
