<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
        	
            $table->increments('rooms_id');
            $table->unsignedInteger('admin_id');
            $table->unsignedInteger('area_id');
            $table->string("admin_email");
            $table->string('room_name',25);
            $table->unsignedInteger('status')->default(0);
            $table->unsignedInteger('allow_book')->default(0);
            $table->dateTime('office_time')->default('00:00');
            $table->dateTime('closing_time')->default('23:59');
            $table->unsignedInteger('time_length')->default(1440);
            $table->unsignedInteger('default_time_length')->default(1440);
            $table->unsignedInteger('need_permission')->default(0);
            $table->unsignedInteger('allow_remind')->default(0);
            $table->unsignedInteger('allow_private_book')->default(0);
            $table->string("order_array")->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('galleryful')->default(0); //容纳人数
            $table->text('goods')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('user_id')->on('users');
            $table->foreign('area_id')->references('area_id')->on('area');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rooms');
    }
}
