<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('postalcode')->nullable()->default(null);
            $table->string('address_line_1')->nullable()->default(null);
            $table->string('address_line_2')->nullable()->default(null);
            $table->foreignId('country_id')->nullable()->default(null)->references('id')->on('countries');
            $table->string('position')->nullable()->default(null);
            $table->integer('salary')->nullable()->default(null);
            $table->foreignId('role_id')->nullable()->default(null)->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropColumn('phone');
            $table->dropColumn('city');
            $table->dropColumn('postalcode');
            $table->dropColumn('address_line_1');
            $table->dropColumn('address_line_2');
            $table->dropColumn('country_id');
            $table->dropColumn('position');
            $table->dropColumn('salary');
        });
    }
}
