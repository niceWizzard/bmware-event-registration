<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->realText('256');
        $date = Carbon::parse($this->faker->dateTime());
        $shortName = $this->faker->word();
        return [
            'title' => $title,
            'slug' => Event::generateSlug($title),
            'short_name' => $shortName,
            'description' => $this->faker->realText('1000'),
            'venue' => $this->faker->address(),
            'partner' => $this->faker->name(),
            'start_date' => $date,
            'end_date' => $date->copy()->addDays($this->faker->numberBetween(1, 3)),
            'registration_start_date' => $date->copy()->subDays($this->faker->numberBetween(1, 3)),
            'registration_end_date' => $date->copy()->addDays($this->faker->numberBetween(1, 3)),
        ];
    }
}
