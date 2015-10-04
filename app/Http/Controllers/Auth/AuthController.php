<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends \App\Http\Controllers\Controller
{
    
    public function login()
    {
        return view('login');
    }

    public function signup()
    {
        return view('signup');
    }
    
    public function authenticate()
    {
        $attempt = Auth::attempt([
            'email' => Request::input('email'),
            'password' => Request::input('password')
        ]);
        
        if( ! $attempt)
            return redirect('login');
            
        return redirect()->intended('/');
        
    }
    
    public function register()
    {
        
    }
}