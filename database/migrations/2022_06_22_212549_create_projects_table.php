<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', ['not_started', 'in_progess', 'finished'])->default('not_started');
            $table->date('start_date');
            $table->date('deadline_date');
            $table->date('soft_deadline_date');
            $table->foreignId('client_id')->references('id')->on('clients');
            $table->unsignedInteger('budget')->nullable()->default(null);
            $table->integer('importance')->default(0);
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
        Schema::dropIfExists('projects');
    }
}
