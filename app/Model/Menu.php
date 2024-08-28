<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;
    protected $table = 'Menu';
    protected $primaryKey = 'MenuId';

    public function userMenu(){
        return $this->hasMany('\App\Model\UserMenu','MenuId','MenuId');
    }
}
