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
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        \App\Models\User::factory(10)->create();
        \App\Models\Tag::factory(30)->create();
        \App\Models\Skill::factory(30)->create();
        \App\Models\Country::factory(10)->create();
        \App\Models\Contact::factory(10)->create();
        \App\Models\Client::factory(10)->create();
    }
}
