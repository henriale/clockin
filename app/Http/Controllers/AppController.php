<?php

namespace App\Http\Controllers;

use App\User;

class AppController extends Controller
{
    public function home()
    {
        return view('home');
    }
    
    public function saveTime()
    {
        return redirect()->back()->with(['message'=>[
            'type' => 'success',
            'text' => 'saved',
        ]]);
    }
}