<?php

namespace Database\Factories;

use App\Models\Form;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Form>
 */
class FormFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => ["sk" => $this->faker->word, "en" => $this->faker->word],
        ];
    }
}
