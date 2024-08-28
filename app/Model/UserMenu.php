<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserMenu extends Model
{
    public $timestamps = false;
    protected $table = 'UserMenu';
//    protected $primaryKey = 'UserId';
    protected $fillable = ['UserId','MenuId'];

    public function menu() {
        return $this->belongsTo('\App\Model\Menu','MenuId','MenuId');
    }
}
