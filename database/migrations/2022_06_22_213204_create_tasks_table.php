<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', ['todo', 'open', 'in_progess', 'ready_for_code_review', 'code_reviewed', 'ready_for_testing', 'testing', 'done']);
            $table->integer('priority')->nullable()->default(null);
            $table->integer('estimate')->nullable()->default(null)->comment('value in minutes');
            $table->integer('story_points')->nullable()->default(null);
            $table->text('description');
            $table->foreignId('project_id')->references('id')->on('projects');
            $table->date('deadline')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
