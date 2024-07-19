<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UserRegisterController extends Controller
{
    //
    public function init()
    {
        return Inertia::render('Register');
    }

    public function store(){
        return "hey";
    }
    
}
