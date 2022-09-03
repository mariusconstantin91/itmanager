<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('skills')->truncate();
        Schema::enableForeignKeyConstraints();

        $skills = [
            'CSS',
            'HTML',
            'PHP',
            'MYSQL',
            'UI',
            'JAVASCRIPT',
            'VUEJS',
            'REACT',
            'ANGULAR',
            'LIVEWIRE',
            'JAVA',
            'TESTING',
            'DEVOPS',
            'GOOLECLOUD',
            'AMAZON',
            'GIT',
            'SEO',
            'MARIADB',
            'ORACLE',
            'UX',
            'UI',
            'C#',
            'AJAX',
            'RUBY',
            'PHYTON',
        ];
        foreach($skills as $skill) {
            Skill::create([
                'name' => $skill
            ]);
        }
    }
}
