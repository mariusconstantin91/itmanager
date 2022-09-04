<?php

namespace Database\Factories;

use App\Models\Client;
use Carbon\Carbon;
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
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->faker->dateTimeBetween('-1 years')->format('Y-m-d H:i:s'));
        $deadlineDate = clone $startDate->addDays(rand(100, 1000));
        $softDateline = clone $deadlineDate->subDays(rand(10, 30));

        return [
            'name' => $this->faker->name() . ' Project',
            'status' => $this->faker->randomElement(['not_started', 'in_progess', 'finished']),
            'start_date' => $startDate->format('Y-m-d'),
            'deadline_date' => $deadlineDate->format('Y-m-d'),
            'soft_deadline_date' => $softDateline->format('Y-m-d'),
            'budget' => $this->faker->numberBetween(0, 10000000),
            'importance' => $this->faker->numberBetween(0, 4),
            'client_id' => Client::inRandomOrder()->first()->id,
        ];
    }
}