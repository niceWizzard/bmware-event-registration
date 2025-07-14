<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Database\Seeder;

class HugeRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event = Event::factory()->create();
        for ($i = 0; $i < 1_000; $i++) {
            EventRegistration::factory()->create([
                'event_id' => $event->id,
                'mobile_number' => '093939039',
            ]);
        }
    }
}
