<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

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
    
    protected $hidden = ['password'];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setUsernameAttribute($username)
    {
        $this->attributes['username'] = strtolower($username);
    }
}