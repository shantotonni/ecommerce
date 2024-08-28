<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    protected $table = 'CouponUser';
    protected $primaryKey = 'CouponID';
    public $timestamps = false;
}
