<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class RoomController extends Controller
{
	public function newRoom()
	{
		return room_insert()->newRoom();
	}
	
	public function checkRoom()
	{
		return room_insert()->checkRoom();
	}
	
	public function updateRoom()
	{
		return room_insert()->updateRoom();
	}
	
	public function deleteRoom()
	{
		return room_insert()->deleteRoom();
	}
}
