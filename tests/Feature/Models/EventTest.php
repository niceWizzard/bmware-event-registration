<?php

namespace Tests\Feature\Models;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Str;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected bool $seed = true;

    public function test_event_has_registrations(): void
    {
        $event = Event::factory()->create();

        $this->assertIsIterable($event->registrations);

        EventRegistration::factory(10)->create([
            'event_id' => $event->id,
        ]);
        $event->refresh();
        $this->assertCount(10, $event->registrations);
    }


}
