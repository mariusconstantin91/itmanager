<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Country::factory(10)->create();
        $this->call(TagsSeeder::class);
        $this->call(SkillsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(DocumentsSeeder::class);
        $this->call(HolidaysSeeder::class);
        \App\Models\Client::factory(6)->create();
        \App\Models\Project::factory(20)->create();
        \App\Models\TaskGroup::factory(20)->create();
        $this->call(TasksSeeder::class);
        \App\Models\TimeEntry::factory(3000)->create();
        \App\Models\Comment::factory(3000)->create();
    }
}
