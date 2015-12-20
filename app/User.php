<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $table = 'users';
    
    protected $fillable = [
        'name',
        'username',
        'email',
        'password'
    ];

    public static $matched_row = [];
    
    protected $hidden = ['password'];

    public function workdays()
    {
        return $this->hasMany('App\Workday');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setUsernameAttribute($username)
    {
        $this->attributes['username'] = strtolower($username);
    }

    public static function exists($field, $value)
    {
        $matched_row = DB::table('users')->where($field, $value)->get();
        if (count($matched_row)) {
            self::$matched_row = reset($matched_row);
            return true;
        }

        return false;
    }
}

function printr($string){echo'<pre>';print_r($string);echo'</pre>';}function printrx($string){die(printr($string));}
