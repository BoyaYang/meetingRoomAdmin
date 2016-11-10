<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AreaController extends Controller
{
	public function newArea()
	{
		return area_ins()->newArea();
	}
	
	public function deleteArea()
	{
		return area_ins()->deleteArea();
	}
}
