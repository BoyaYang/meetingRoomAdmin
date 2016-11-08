<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

function rq($key=null,$default=null){
    if(!$key) return Request::all();
    else return Request::get($key,$default);
}

function user_ins()
{
    return new App\User;
}

function room_ins()
{
    return new App\Room;
}

function order_ins()
{
    return new App\Order;
}

Route::get('/', function () {
    return view('welcome');
});



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::group(['prefix'=>'api'],function(){

    	Route::group(['prefix'=>'post'],function(){
    		Route::post('users',['as'=>'reg','uses'=>'UserController@register']);
    		Route::any('sessions',['as'=>'login', 'uses'=>'UserController@login']);
    		Route::post('orders',['as'=>'neworder', 'uses'=>'OrderController@order']);
    	});
    	
    	Route::group(['prefix'=>'get'],function(){
    		
    	});
    	
    	Route::group(['prefix'=>'put'],function(){
    		
    	});
    	
    	Route::group(['prefix'=>'delete'],function(){
    		
    	});
    });

});
