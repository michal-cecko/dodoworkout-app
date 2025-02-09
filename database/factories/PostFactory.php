<?php

namespace Database\Factories;

use App\Enum\Locale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ['sk' => $this->faker->sentence, 'en' => $this->faker->sentence],
            'excerpt' => ['sk' => $this->faker->sentences(3), 'en' => $this->faker->sentences(3)],
            'likes' => $this->faker->numberBetween(0, 100),
            'dislikes' => $this->faker->numberBetween(0, 100),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'is_draft' => $this->faker->boolean,
            'content' => json_decode('[{"data": {"content": "<p>Toto je textovy blok</p>"}, "type": "content"}, {"data": {"description": "<p>Toto je popis media</p>"}, "type": "image"}, {"data": {"text": "Citatik nejakej osobnosti", "author": "Autorko", "position": "Neviem"}, "type": "blockquote"}, {"data": [], "type": "gallery"}]'),
            'locale_scope' => $this->faker->randomElement([null, Locale::SK->value, Locale::EN->value]),
        ];
    }
}
