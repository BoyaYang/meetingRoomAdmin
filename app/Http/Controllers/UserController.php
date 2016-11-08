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
}
