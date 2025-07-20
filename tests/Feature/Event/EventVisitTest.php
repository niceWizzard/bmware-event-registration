<?php

namespace Tests\Feature\Event;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class EventVisitTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;


    public function test_show_page(): void
    {
        $event = Event::factory()->create();
        $res = $this->get(route('events.show', $event->short_name));

        $res->assertSee($event->title);
        $res->assertViewHas('event', $event);
    }

    public function test_only_guest_users_cannot_visit(): void
    {
        $event = Event::factory()->create();
        $this->get(route('events.create', $event->short_name))->assertRedirect(route('login'));
        $this->post(route('events.store'), Event::factory()->make()->attributesToArray())
            ->assertRedirect(route('login'));
    }

}
