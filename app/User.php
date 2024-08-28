<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected  $table = 'UserManager';
    protected $primaryKey = 'UserId';
    public $timestamps = false;

    protected $fillable = [
        'UserName', 'Name', 'Designition','StaffId', 'Password',
    ];

    protected $hidden = [
        'Password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['Password'] = bcrypt($value);
    }

    public function scopeFilter($query) {
        $user = Auth::user();
        if($user->Role == 'sa') {
            return $query;
        }
        $superAdmin = User::where('Role','sa')->first();
        return $query->where('UserId','!=',$superAdmin->UserId);
    }

    public function business() {
        return $this->hasMany('App\Model\UserBusiness','UserId','UserId');
    }

    public function project() {
        return $this->hasMany('App\Model\UserProject','UserId','UserId');
    }



}
