<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::statement("SET foreign_key_checks=0");
        Role::truncate();
        DB::statement("SET foreign_key_checks=1");

        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'Admin',
            'guard_name' => 'admin'
        ]);

        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'HR Manager',
            'guard_name' => 'hr_manager'
        ]);

        DB::table('roles')->insert([
            'id' => 3,
            'name' => 'Project Manager',
            'guard_name' => 'pr_manager'
        ]);

        DB::table('roles')->insert([
            'id' => 4,
            'name' => 'User',
            'guard_name' => 'user'
        ]);
    }
}
