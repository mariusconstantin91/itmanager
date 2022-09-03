<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('postalcode')->nullable()->default(null);
            $table->string('address_line_1')->nullable()->default(null);
            $table->string('address_line_2')->nullable()->default(null);
            $table->foreignId('country_id')->nullable()->default(null)->references('id')->on('countries');
            $table->foreignId('client_id')->nullable()->default(null)->references('id')->on('clients');
            $table->boolean('main_contact')->default(false);
            $table->string('position')->nullable()->default(null);
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
        Schema::dropIfExists('contacts');
    }
}
