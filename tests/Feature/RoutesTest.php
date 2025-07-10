<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_home_page(): void
    {
        $this->get(route('home'))->assertOk();
    }

    // ------------ Auth
    public function test_login_page(): void
    {
        $this->get(route('login'))->assertOk();
    }


    // ------------ ADMIN
    public function test_admin_dashboard_page(): void
    {

        $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    // --------------------- EVENTS
    public function test_events_index_page(): void
    {
        $this->get(route('events.index'))
            ->assertOk();
    }

    public function test_events_show_page(): void
    {
        $event = Event::factory()->create();
        $this->get(route('events.show', $event->slug))
            ->assertOk();
    }
}
