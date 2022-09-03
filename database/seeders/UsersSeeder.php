<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        // Super Admin
        if (!User::where('email', 'admin@itmanager.com')->exists()) {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@itmanager.com',
                'password' => 'asdf1234',
                'role_id' => 1 //admin
            ]);
        }

        // HR Manager
        if (!User::where('email', 'hr@itmanager.com')->exists()) {
            $user = User::create([
                'name' => 'HR Manager',
                'email' => 'hr@itmanager.com',
                'password' => 'asdf1234',
                'role_id' => 2 //hr
            ]);
        }

        // HR Manager
        if (!User::where('email', 'project_manager@itmanager.com')->exists()) {
            $user = User::create([
                'name' => 'Project MAnager',
                'email' => 'project_manager@itmanager.com',
                'password' => 'asdf1234',
                'role_id' => 3 //project manager
            ]);
        }

        // User
        if (!User::where('email', 'user@itmanager.com')->exists()) {
            $user = User::create([
                'name' => 'User',
                'email' => 'user@itmanager.com',
                'password' => 'asdf1234',
                'role_id' => 4 //user
            ]);
        }

        User::factory()->count(30)->create();

        $users = User::where('role_id', 4)->get();
        foreach($users as $user) {
            $n = rand(1, 4);
            $sync = [];
            for($i=0; $i<$n; $i++) {
                $sync[] = [
                    rand(1, 25) => ['importance' => rand(0, 4)],
                ];
            }
        }

        $user->skills()->sync($sync);
    }
}
