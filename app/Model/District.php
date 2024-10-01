<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;
    protected $table = 'vDistrict';
    protected $primaryKey = 'DistrictCode';
    protected $keyType = 'string';
}
