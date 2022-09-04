<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = Project::factory()->count(20)->create();

        $tags = Tag::all();
        $skills = Skill::all();
        $projectManagers = User::where('role_id', 3)->get();

        // Populate the pivot table
        $projects->each(function ($project) use ($tags, $skills, $projectManagers) { 
            $tagsIds = [];
            $tags->random(rand(1, 3))->pluck('id')
                ->each(function ($item) use (&$tagsIds) {
                    $tagsIds[$item] = [
                        'importance' => rand(0, 4),
                    ];
                })->toArray();
            $project->tags()->sync($tagsIds);
            
            $skillsIds = [];
            $skills->random(rand(1, 3))->pluck('id')
                ->each(function ($item) use (&$skillsIds) {
                    $skillsIds[$item] = [
                        'importance' => rand(0, 4),
                    ];
                })->toArray();

            $project->skills()->sync($skillsIds);

            $projectManagerIds = $projectManagers->random(rand(1, 2))->pluck('id')->toArray();
            $project->users()->sync($projectManagerIds);
        });
    }
}
