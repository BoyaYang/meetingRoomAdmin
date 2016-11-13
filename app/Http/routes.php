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

function area_ins()
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

    Route::group(['prefix'=>'api'],function()
    {

    	Route::group(['prefix'=>'post'],function()
    	{
    		Route::post('users',['as'=>'register','uses'=>'UserController@register']);
    		Route::post('sessions',['as'=>'login', 'uses'=>'UserController@login']);
    		Route::post('orders',['as'=>'newOrder', 'uses'=>'OrderController@newOrder']);
    		Route::post('areas',['as'=>'newOrder', 'uses'=>'OrderController@newOrder']);
    		Route::post('rooms',['as'=>'newRoom', 'uses'=>'RoomController@newRoom']);
    	});
    	
    	Route::group(['prefix'=>'get'],function()
    	{
    		Route::post('orders',['as'=>'checkOrder','uses'=>'OrderController@checkOrder']);
    		Route::post('rooms',['as'=>'checkRoom','uses'=>'RoomController@checkRoom']);
    	});
    	
    	Route::group(['prefix'=>'put'],function()
    	{
    		Route::post('orders',['as'=>'updateOrder', 'uses'=>'OrderController@updateOrder']);
    		Route::post('rooms',['as'=>'updateRoom', 'uses'=>'RoomController@updateRoom']);
    	});
    	
    	Route::group(['prefix'=>'delete'],function()
    	{
    		Route::post('orders',['as'=>'deleteOrder','uses'=>'OrderController@deleteOrder']);
    		Route::post('rooms',['as'=>'deleteRoom','uses'=>'RoomController@deleteOrder']);
    		Route::post('sessions/users',['as'=>'logout','uses'=>'UserController@logout']);
    		Route::post('areas',['as'=>'deleteArea','uses'=>'AreaController@deleteArea']);
    	});
});
