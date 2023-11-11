<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //$faker = \Faker\Factory::create('en_US');
        return [
            "name" => fake()->sentence($nbWords = 3),
            "description" => fake()->sentences($nb = 7, $asText = true),
            "code" => 'IK-' . fake()->regexify('[A-Z]{3}[0-9]{3}'),
            "credit" => fake()->numberBetween($min = 0, $max = 10),
            "image_url" => fake()->imageUrl(),
        ];
    }

    /**
    * Indicate that the course belongs to a teacher.
    *
    * @param  \App\Models\User  $teacher
    * @return $this
    */
    public function forTeacher(User $teacher)
    {
        return $this->state(function (array $attributes) use ($teacher) {
            return [
                'user_id' => $teacher->id,
            ];
        });
    }
}
