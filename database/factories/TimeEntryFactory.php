<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $task = Task::inRandomOrder()->first();
        $user = $task->users()->inRandomOrder()->first();
        $project = $task->project;

        $startAt = $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:00');
        $endAt = Carbon::createFromFormat('Y-m-d H:i:s', $startAt)->addMinutes($this->faker->numberBetween(15, 480))->format('Y-m-d H:i:00');

        return [
            'start_at' => $startAt,
            'end_at' => $endAt,
            'description' => $this->faker->realText(),
            'task_id' => $task ? $task->id : Task::factory(),
            'user_id' => $user ? $user->id : User::factory(),
            'project_id' => $project ? $project->id : Project::factory(),
        ];
    }
}