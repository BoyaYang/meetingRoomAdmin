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
        	$table->increments('id');
        	$table->unsignedInteger('user_id')->nullable();
        	$table->unsignedInteger('admin_id')->nullable();
        	$table->text('brief_description');
        	$table->text('inte_description');
        	$table->dateTime('start_time');
        	$table->dateTime('end_time');
        	$table->unsignedInteger('type');
        	$table->unsignedInteger('status');
        	$table->timestamps();
        	
        	$table->foreign('admin_id')->references('id')->on('users');
        	$table->foreign('user_id')->references('id')->on('users');
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
