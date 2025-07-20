<?php

namespace Database\Factories;

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
        $title = $this->faker->realText('72');
        $date = Carbon::parse($this->faker->dateTime());
        $shortName = $this->faker->unique()->word();
        return [
            'title' => $title,
            'visibility' => $this->faker->randomElement(['public', 'private']),
            'short_name' => $shortName,
            'description' => $this->faker->realText('255'),
            'body' => $this->generateRandomHtmlSnippet(),
            'venue' => $this->faker->address(),
            'partner' => $this->faker->name(),
            'start_date' => $date,
            'end_date' => $date->copy()->addDays($this->faker->numberBetween(1, 3)),
            'registration_start_date' => $date->copy()->subDays($this->faker->numberBetween(1, 3)),
            'registration_end_date' => $date->copy()->addDays($this->faker->numberBetween(1, 3)),
        ];
    }

    private function generateRandomHtmlSnippet(): string
    {
        $faker = $this->faker;
        $htmlParts = [];

        // Optionally add a heading
        if ($faker->boolean(70)) {
            $heading = $faker->numberBetween(1, 3);
            $htmlParts[] = "<h$heading>{$faker->sentence()}</h$heading>";
        }

        // Add 1–3 paragraphs with optional inline formatting
        foreach (range(1, $faker->numberBetween(1, 3)) as $_) {
            $paragraph = $faker->sentence(10);

            // Randomly bold, italicize, or underline words
            $words = explode(' ', $paragraph);
            foreach ($words as &$word) {
                $chance = $faker->numberBetween(1, 100);
                if ($chance <= 10) $word = "<b>$word</b>";
                elseif ($chance <= 20) $word = "<i>$word</i>";
                elseif ($chance <= 25) $word = "<u>$word</u>";
            }

            $htmlParts[] = '<p>' . implode(' ', $words) . '</p>';
        }

        // Optionally add an unordered list
        if ($faker->boolean(50)) {
            $items = array_map(fn() => "<li data-list='bullet'>{$faker->word()}</li>", range(1, $faker->numberBetween(2, 5)));
            $htmlParts[] = "<ol>" . implode('', $items) . "</ol>";
        }

        // Optionally add an ordered list
        if ($faker->boolean(50)) {
            $items = array_map(fn() => "<li data-list='ordered'>{$faker->word()}</li>", range(1, $faker->numberBetween(2, 5)));
            $htmlParts[] = "<ol>" . implode('', $items) . "</ol>";
        }

        return implode("\n", $htmlParts);
    }


}
