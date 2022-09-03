<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name() . ' Project',
            'status' => $this->faker->randomElement(['not_started', 'in_progess', 'finished']),
            'start_date' => $this->faker->date(),
            'deadline_date' => $this->faker->date(),
            'soft_deadline_date' => $this->faker->date(),
            'budget' => $this->faker->numberBetween(0, 10000000),
            'importance' => $this->faker->numberBetween(0, 4),
            'client_id' => Client::factory(),
        ];
    }
}