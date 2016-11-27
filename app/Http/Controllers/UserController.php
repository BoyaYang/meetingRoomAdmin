<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    public function register()
    {
        return user_ins()->register();
    }

    public function login()
    {
        return user_ins()->login();
    }
    
    public function logout()
    {
    	return user_ins()->logout();
    }
    
    public function deleteUser()
    {
    	return user_ins()->deleteRoom();
    }
    
    public function test()
    {
    	return dd(user_ins()->is_logged_in());
    }
}
