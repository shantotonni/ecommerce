<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Upazilla extends Model
{
    public $timestamps = false;
    protected $table = 'vUpazilla';
    protected $primaryKey = 'UpazillaCode';
}
