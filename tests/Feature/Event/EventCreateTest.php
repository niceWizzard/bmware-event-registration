<?php

namespace Tests\Feature\Event;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class EventCreateTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_create_basic_constraints(): void
    {
        $attributes = Arr::except(
            Event::factory()->make()->attributesToArray(),
            ['banner_url', 'short_name']
        );
        $this->actingAs(User::factory()->create());
        foreach ($attributes as $attribute => $value) {
            $this->post(route('events.store'), Arr::except($attributes, $attribute))
                ->assertSessionHasErrors($attribute);
        }
    }

    public function test_event_start_should_be_before_event_end(): void
    {
        $event = Event::factory()->make([
            'start_date' => now(),
            'end_date' => now()->subDay(),
        ]);
        $this->actingAs(User::factory()->create());
        $this->post(
            route('events.store'),
            $event->attributesToArray()
        )->assertSessionHasErrors('start_date');
    }

    public function test_reg_start_is_not_after_reg_end(): void
    {
        $event = Event::factory()->make([
            'registration_start_date' => now()->addDay(),
            'registration_end_date' => now(),
        ]);
        $this->actingAs(User::factory()->create());
        $this->post(
            route('events.store'),
            $event->attributesToArray(),
        )->assertSessionHasErrors('registration_start_date');
    }

    public function test_reg_end_is_not_after_event_start(): void
    {
        $event = Event::factory()->make([
            'registration_end_date' => now()->addDay(),
            'event_start' => now(),
        ]);
        $this->actingAs(User::factory()->create());
        $this->post(
            route('events.store'),
            $event->attributesToArray(),
        )->assertSessionHasErrors('registration_end_date');
    }

    public function test_event_start_end_equal(): void
    {
        $now = now();
        $event = Event::factory()->make([
            'start_date' => $now,
            'end_date' => $now,
        ]);
        $this->actingAs(User::factory()->create());
        $this->post(
            route('events.store'),
            $event->attributesToArray()
        )->assertSessionHasErrors('end_date');
    }


}
