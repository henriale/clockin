<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Mailler;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check() === true) {
            return redirect('/');
        }

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

        if( ! Auth::attempt($credentials, true)) {
            return view('/login')->with([
                'messages' => [[
                    'type' =>  'danger',
                    'text' => 'Invalid e-mail or password'
                ]]
            ]);
        }

        Auth::login(Auth::user());
        return redirect('/');
        
    }
    
    public function register(\Illuminate\Http\Request $request)
    {
        // TODO: Validation
        // TODO: get username properly
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'same:passwordConfirmation',
            'passwordConfirmation' => 'required',
        ]);

        $credentials = [
            'username' => str_random(10),
            'email' => Request::input('email'),
            'password' => Request::input('password')
        ];

        try {
            User::create($credentials);
            $mailler = new Mailler();
            $mailler->subscribe($credentials['username'], $credentials['email']);

        } catch (QueryException $e) {
            $errorMessage = $e->errorInfo[2];
        }

        return redirect('/login')->with([
            'messages' => [[
                'type' => isset($errorMessage) ? 'danger': 'success',
                'text' => isset($errorMessage) ?: 'Registration completed!'
            ]]
        ]);
    }
}
