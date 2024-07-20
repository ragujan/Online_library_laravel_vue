<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class UserLoginController extends Controller
{
    //
    public function init()
    {
        return Inertia::render('Login');
    }

    public function store(LoginRequest $request)
    {
        // login request class has the method to authenticate

        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended(route('home', absolute: false));
    }

}
