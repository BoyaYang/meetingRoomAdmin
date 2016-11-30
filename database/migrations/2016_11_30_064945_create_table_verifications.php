<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVerifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('phoneVerf')->nullable();
            $table->string('emailVerf')->nullable();
            $table->tinyInteger('phoneAccess');
            $table->tinyInteger('emailAccess');
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
        Schema::drop('verifications');
    }
}

