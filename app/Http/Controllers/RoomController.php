<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class RoomController extends Controller
{
	public function newRoom()
	{
		return room_ins()->newRoom();
	}
	
	public function checkRoom()
	{
		return room_ins()->checkRoom();
	}
	
	public function updateRoom()
	{
		return room_ins()->updateRoom();
	}
	
	public function deleteRoom()
	{
		return room_ins()->deleteRoom();
	}
}
