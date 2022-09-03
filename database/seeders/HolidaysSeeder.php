<?php

namespace Database\Seeders;

use App\Models\Holiday;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HolidaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('documents')->truncate();
        Schema::enableForeignKeyConstraints();

        Holiday::factory()->count(100)->create();
    }
}
