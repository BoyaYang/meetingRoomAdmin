<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    public function register()
    {
        return user_insert()->register();
    }

    public function emailVerification()
    {
        return user_insert()->checkEmailVerification();
    }

    public function login()
    {
        return user_insert()->login();
    }
    
    public function logout()
    {
    	return user_insert()->logout();
    }
    
    public function deleteUser()
    {
    	return user_insert()->deleteUser();
    }

    public function phoneVerification()
    {
        return user_insert()->checkPhoneVerification();
    }
    
   /* public function test()
    {
    	return dd(user_insert()->is_logged_in());
    }*/
}
