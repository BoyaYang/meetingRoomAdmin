<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class OrderController extends Controller
{
    public function newOrder()
    {
        return order_ins()->newOrder();
    }
    
    public function updateOrder()
    {
    	return order_ins()->updateOrder();
    }
    
    public function deleteOrder()
    {
    	return order_ins()->deleteOrder();
    }
}
