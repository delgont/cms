<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Delgont\Cms\Concerns\HasRoles;
use Delgont\Cms\Concerns\HasPermissions;
use Delgont\Cms\Concerns\HasActivityLog;
use Delgont\Cms\Models\Concerns\CanComment;
use Delgont\Cms\Models\Concerns\HasAvator;
use Delgont\Cms\Models\Concerns\HasUserType;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasPermissions, HasRoles, HasActivityLog, CanComment, HasAvator, HasUserType;

    
    protected $appends = array('type');
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $with = ['avator:id,url,iconable_id'];

    

}
