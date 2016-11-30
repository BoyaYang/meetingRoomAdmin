<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class VerificationController extends Controller
{
    public function emailVerf()
    {
        return verification_insert()->getEmailVerf();
    }
}
