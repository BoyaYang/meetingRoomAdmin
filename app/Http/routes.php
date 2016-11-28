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

function rq($key=null,$default=null)
{
    if(!$key) return Request::all();
    else return Request::input($key,$default);
}

function user_insert()
{
    return new App\User;
}

function room_insert()
{
    return new App\Room;
}

function order_insert()
{
    return new App\Order;
}

function area_insert()
{
	return new App\Area;
}

Route::get('/', function ()
{
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

Route::group(['middleware' => ['web']], function ()
{
    	Route::post('users',['as'=>'register','uses'=>'UserController@register']);
    	Route::post('users/token',['as'=>'login', 'uses'=>'UserController@login']);
    	Route::post('orders',['as'=>'newOrder', 'uses'=>'OrderController@newOrder']);
    	Route::post('areas',['as'=>'newOrder', 'uses'=>'AreaController@newArea']);
    	Route::post('rooms',['as'=>'newRoom', 'uses'=>'RoomController@newRoom']);
   	
   		Route::get('orders/{id}',['as'=>'checkOrder','uses'=>'OrderController@checkOrder']);
   		Route::get('rooms/{id}',['as'=>'checkRoom','uses'=>'RoomController@checkRoom']);
   		Route::get('areas/{id}',['as'=>'checkArea','uses'=>'RoomController@checkArea']);
   		Route::get('orders',['as'=>'checkOrder','uses'=>'OrderController@checkOrder']);
   		Route::get('rooms',['as'=>'checkRoom','uses'=>'RoomController@checkRoom']);
   		Route::get('areas',['as'=>'checkArea','uses'=>'AreaController@checkArea']);
   	
   		Route::put('orders/{id}',['as'=>'updateOrder', 'uses'=>'OrderController@updateOrder']);    	
   		Route::put('rooms/{id}',['as'=>'updateRoom', 'uses'=>'RoomController@updateRoom']);
    
   		Route::delete('orders/{id}',['as'=>'deleteOrder','uses'=>'OrderController@deleteOrder']);
   		Route::delete('rooms/{id}',['as'=>'deleteRoom','uses'=>'RoomController@deleteRoom']);
   		Route::delete('users/token',['as'=>'logout','uses'=>'UserController@logout']);
   		Route::delete('areas/{id}',['as'=>'deleteArea','uses'=>'AreaController@deleteArea']);
   		Route::delete('users/{id}',['as'=>'deleteUser','uses'=>'UserController@deleteUser']);
   		
   		
   		//Route::get('test',['uses'=>'UserController@test']);
});