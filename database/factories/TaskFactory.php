<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->realText(1000),
            'status' => $this->faker->randomElement(['todo', 'open', 'in_progess', 'ready_for_code_review', 'code_reviewed', 'ready_for_testing', 'testing', 'done']),
            'priority' => $this->faker->numberBetween(0, 4),
            'estimate' => $this->faker->numberBetween(1, 30) * 10,
            'story_points' => $this->faker->randomElement([1, 2, 3, 5, 8, 13, 21, 34]),
            'deadline' => $this->faker->dateTime('+ 3 weeks'),
            'project_id' => Project::factory()
        ];
    }
}
