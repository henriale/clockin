<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Database\QueryException;
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
    public function logout()
    {
        // TODO: Validation
        Auth::logout();
        return redirect('/login');
    }

    public function signup()
    {
        return view('signup');
    }
    
    public function authenticate()
    {
        // TODO: Validation
        $credentials = [
            'email' => Request::input('email'),
            'password' => Request::input('password')
        ];

        if( ! Auth::attempt($credentials, true))
            return redirect('login');

        Auth::login(Auth::user());
        return redirect('/');
        
    }
    
    public function register(\Illuminate\Http\Request $request)
    {
        // TODO: Validation
        // TODO: get username properly
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'same:repeat-password',
            'repeat-password' => 'required',
        ]);

        $credentials = [
            'username' => str_random(10),
            'email' => Request::input('email'),
            'password' => Request::input('password')
        ];

        try {
            $user = User::create($credentials);
        } catch (QueryException $e) {
            dd($e->errorInfo[2]);
        }

        Auth::login($user);

        return redirect('/');
    }
}