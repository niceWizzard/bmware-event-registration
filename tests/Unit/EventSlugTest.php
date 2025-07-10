<?php

namespace Tests\Unit;

use App\Models\Event;
use PHPUnit\Framework\TestCase;

class EventSlugTest extends TestCase
{
    public function test_slug_works(): void
    {
        $title = 'Some TITLE ? WOW!';
        $this->assertEquals(
            'some-title-wow',
            Event::generateSlug($title)
        );
    }

    public function test_slug_generation_ignores_special_characters(): void
    {
        $title = 'Some TITLE !#$%^&*()_+<>?:"{}';
        $this->assertEquals(
            'some-title',
            Event::generateSlug($title),
        );
    }

    public function test_slug_on_real_event(): void
    {
        $title = 'Mt. Carmel Blood Donation Drive (2025)';
        $this->assertEquals(
            'mt-carmel-blood-donation-drive-2025',
            Event::generateSlug($title)
        );
    }

}
