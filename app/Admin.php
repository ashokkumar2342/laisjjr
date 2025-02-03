<?php

namespace App;

use App\Model\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use Notifiable,HasApiTokens;

     public $timestamps=false;
    use Notifiable,HasApiTokens;

    protected $rememberTokenName=false;
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

}
