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
            $table->string('room_name',25);
            $table->unsignedInteger('status');
            $table->unsignedInteger('type');
            $table->unsignedInteger('allow_book');
            $table->dateTime('office_time');
            $table->dateTime('closing_time');
            $table->unsignedInteger('time_length');
            $table->unsignedInteger('meeting_time');
            $table->unsignedInteger('need_permission');
            $table->unsignedInteger('allow_remind');
            $table->unsignedInteger('allow_private_book');
            $table->text('html')->nullable();
            $table->text('description');
            $table->unsignedInteger('galleryful'); //容纳人数
            $table->text('goods')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('admin_id')->on('admins');
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
