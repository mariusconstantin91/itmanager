<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $task = Task::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        return [
            'comment' => $this->faker->text(),
            'task_id' => $task ? $task->id : Task::factory(),
            'user_id' => $user ? $user->id : User::factory(),
        ];
    }
}