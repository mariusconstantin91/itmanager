<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Tag;
use App\Models\Task;
use App\Models\TaskGroup;
use App\Models\User;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = Task::factory()->count(20)->create();

        $tags = Tag::all();
        $skills = Skill::all();
        $users = User::all();
        $taskGroups = TaskGroup::all();

        // Populate the pivot table
        $tasks->each(function ($task) use ($tags, $skills, $users, $taskGroups) { 
            $tagsIds = [];
            $tags->random(rand(1, 3))->pluck('id')
                ->each(function ($item) use (&$tagsIds) {
                    $tagsIds[$item] = [
                        'importance' => rand(0, 4),
                    ];
                })->toArray();
            $task->tags()->sync($tagsIds);
            
            $skillsIds = [];
            $skills->random(rand(1, 3))->pluck('id')
                ->each(function ($item) use (&$skillsIds) {
                    $skillsIds[$item] = [
                        'importance' => rand(0, 4),
                    ];
                })->toArray();

            $task->skills()->sync($skillsIds);

            $usersIds = $users->random(rand(1, 3))->pluck('id')->toArray();
            $task->users()->sync($usersIds);

            $taskGroupIds = $taskGroups->random(rand(1, 3))->pluck('id')->toArray();
            $task->taskGroups()->sync($taskGroupIds);
            
        });
    }
}
