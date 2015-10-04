<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends \App\Http\Controllers\Controller
{
    
    public function login()
    {
        if (Auth::check() === true)
            return redirect('/');

        return view('login');
    }

    public function signup()
    {
        return view('signup');
    }
    
    public function authenticate()
    {
        $credentials = [
            'email' => Request::input('email'),
            'password' => Request::input('password')
        ];

        if( ! Auth::attempt($credentials, true))
            return redirect('login');

        Auth::login(Auth::user());
        return redirect('/');
        
    }
    
    public function register()
    {
        
    }
}