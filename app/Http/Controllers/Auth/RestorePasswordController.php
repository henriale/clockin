<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use App\Http\Middleware\Mailler;

class RestorePasswordController extends Controller
{
    public function recover()
    {
        return view('recover');
    }

    public function makeRecoverRequest()
    {
        if (!User::exists('email', Request::input('email'))) {
            return redirect('signup');
        }

        $body = "<a href='".url('/restore?k='.User::$matched_row['remember_token'])."' target='_blank'>";
        $body .= 'Click here to reset your password</a>';

        $mail = new Mailler();
        $mail->destinatary = User::$matched_row['email'];
        $mail->subject = 'Reset your Password';
        $mail->body = $body;
        $mail->sendMessage();

        return redirect('login');
    }

    public function createNewPassword()
    {
        $remember_token = Request::only('k')['k'];

        return view('restore')
            ->with(compact('remember_token'));
    }

    public function rebuildPassword()
    {
        try {
            User::where('email', Request::input('email'))
                ->where('remember_token', Request::input('remember_token'))
                ->update(['password' => bcrypt(Request::input('password'))]);
        } catch (\Exception $e) {

        }

        return redirect('/login');
    }
}
