<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $taskGroupsNames = [
            'Admin',
            'Account',
            'Auth',
            'Backend',
            'Blog',
            'Bugs',
            'Categories',
            'Change request',
            'Checkout page',
            'Environment',
            'Feedback',
            'Frontend',
            'Geolocation',
            'Guides',
            'Home',
            'Media uploader',
            'Navigation',
            'On hold',
            'Pages',
            'Payment provider',
            'Products',
            'Settings',
            'Sprint 1',
            'Sprint 2',
            'Sprint 3',
            'Testing',
            'Translate',
            'To be discussed',
            'Users',
        ];
        return [
            'name' => $this->faker->unique()->randomElement($taskGroupsNames),
            'description' => $this->faker->realText(1000),
            'project_id' => Project::factory(),
        ];
    }
}
