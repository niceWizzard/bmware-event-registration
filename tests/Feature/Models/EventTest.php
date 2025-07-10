<?php

namespace Tests\Feature\Models;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Str;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected bool $seed = true;

    public function test_banner_url(): void
    {
        $event = Event::factory()->create([
            'banner' => 'some-banner.png',
        ]);
        $this->assertTrue(
            Str::contains(
                $event->banner_url,
                $event->banner,
            )
        );
    }


}
