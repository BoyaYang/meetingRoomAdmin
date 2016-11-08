<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders',function (Blueprint $table){

        	$table->increments('order_id');
        	$table->unsignedInteger('user_id')->nullable;
        	$table->unsignedInteger('admin_id');
        	$table->text('brief_desc');
        	$table->text('inte_desc');
        	$table->dateTime('start_time');
        	$table->dateTime('end_time');
        	$table->unsignedInteger('type');
        	$table->unsignedInteger('status');
        	$table->unsignedInteger('repeat_type');
        	$table->dateTime('stop_repeat_time');
        	$table->unsignedInteger('skip_same');
        	$table->timestamps();
        	
        	$table->foreign('admin_id')->references('admin_id')->on('admins');
        	$table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
