<?php

namespace Database\Factories;

use App\Models\PostTag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostTag>
 */
class PostTagFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => ["sk" => $this->faker->word, "en" => $this->faker->word],
        ];
    }
}
