<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserManager extends Model
{
    protected $table = 'UserManager';
    protected $primaryKey = 'UserId';
    public $timestamps = false;

    public function thana() {
        return $this->hasMany('App\Model\UserUpazilla','UserId','UserId');
    }
}
