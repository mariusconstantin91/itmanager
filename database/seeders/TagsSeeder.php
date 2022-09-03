<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('tags')->truncate();
        Schema::enableForeignKeyConstraints();

        $tags = [
            'admin',
            'account',
            'auth',
            'backend',
            'blog',
            'bug fix',
            'categories',
            'change request',
            'checkout page',
            'environment',
            'feedback',
            'frontend',
            'geolocation',
            'guides',
            'home',
            'media uploader',
            'navigation',
            'on hold',
            'pages',
            'payment provider',
            'products',
            'settings',
            'testing',
            'translate',
            'to be discussed',
            'users',
        ];
        foreach($tags as $tag) {
            Tag::create([
                'name' => $tag
            ]);
        }
    }
}
