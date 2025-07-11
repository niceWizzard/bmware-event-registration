<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'short_name',
        'slug',
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
        'registration_start' => 'datetime',
        'registration_end' => 'datetime',
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    protected $appends = [
        'banner_url',
    ];

    public static function generateSlug(string $title, int $limit = 72): string
    {
        // Convert title to a slug (e.g., "Hello World!" => "hello-world")
        return Str::slug(
            Str::limit($title, $limit, '')
        );
    }

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
}
