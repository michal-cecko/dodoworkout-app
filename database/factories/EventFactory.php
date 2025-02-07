<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        $start_at = $this->faker->dateTimeBetween('now', '+1 month');
        return [
            'title' => ['sk' => $this->faker->sentence, 'en' => $this->faker->sentence],
            'excerpt' => ['sk' => $this->faker->paragraph(3), 'en' => $this->faker->paragraph(3)],
            'start_at' => $start_at,
            'end_at' => $this->faker->randomElement([null, $this->faker->dateTimeBetween($start_at->modify("+1 day"), $start_at->modify("+7 day"))]),
            'is_draft' => $this->faker->boolean,
            'content' => json_decode('[{"data": {"content": "<p>Toto je textovy blok</p>"}, "type": "content"}, {"data": {"description": "<p>Toto je popis media</p>"}, "type": "image"}, {"data": {"text": "Citatik nejakej osobnosti", "author": "Autorko", "position": "Neviem"}, "type": "blockquote"}, {"data": [], "type": "gallery"}]'),
            'has_location' => $this->faker->boolean,
            'address' => ['sk' => $this->faker->sentence(2), 'en' => $this->faker->sentence(2)],
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'participants_count' => $this->faker->numberBetween(10, 100),
            'price' => $this->faker->numberBetween(0, 100),
            'last_price' => $this->faker->randomElement([null, $this->faker->numberBetween(0, 100)]),
        ];
    }
}
