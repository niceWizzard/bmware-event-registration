<?php

namespace Tests\Feature\Models;

use App\Models\Event;
use App\Models\EventRegistration;
use Tests\TestCase;

class EventRegistrationTest extends TestCase
{
    public function test_event_token_auto_create(): void
    {
        $event = Event::factory()->create();
        $eventRegistration = EventRegistration::factory()->create([
            'event_id' => $event->id,
        ]);
        $this->assertNotNull($eventRegistration->token);
    }

}
