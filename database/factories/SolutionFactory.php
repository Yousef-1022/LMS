<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Solution>
 */
class SolutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amountOfSentences = fake()->numberBetween($min = 5, $max = 15);
        return [
            'answer' => fake()->sentences($nb = $amountOfSentences, $asText = true),
        ];
    }
}
