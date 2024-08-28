<?php

namespace App\Model;

use App\Http\Controllers\CommonHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Business extends Model
{
    protected $table='Business';
    protected $primaryKey = 'Business';
    public $incrementing = false;
}
