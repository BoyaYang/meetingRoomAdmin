<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class OrderController extends Controller
{
    public function newOrder()
    {
        return order_insert()->newOrder();
    }
    
    public function checkOrder()
    {
    	return room_insert()->checkOrder();
    }
    
    public function updateOrder()
    {
    	return order_insert()->updateOrder();
    }
    
    public function deleteOrder()
    {
    	return order_insert()->deleteOrder();
    }
}
