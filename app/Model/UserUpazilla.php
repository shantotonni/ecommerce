<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserUpazilla extends Model
{
    protected $table = 'UserUpazilla';
    public $timestamps =  false;
    protected $primaryKey = 'ID';
    protected $guarded = [];
}
