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
            'css',
            'html',
            'php',
            'mysql',
            'ui',
            'javascript',
            'vue js',
            'react',
            'angular',
            'livewire',
            'laravel',
            'jave',
            'testing',
            'servers',
            'git',
            'seo',
            'maria db',
            'sql',
            'postgresql',
            'ux',
            'c#',
            'ajax',
            'ruby',
            'phyton',
        ];
        foreach($skills as $skill) {
            Skill::create([
                'name' => $skill
            ]);
        }
    }
}
