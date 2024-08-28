<?php

namespace App\Model;

use App\Http\Controllers\CommonHelper;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'Customer';
    public $timestamps = false;
    protected $primaryKey = 'CustomerID';

    public function customerAddress(){

        return $this->hasMany('App\Model\CustomerAddress', 'CustomerID','CustomerID');
    }

    public function scopePermitted($query)
    {
        $projectIds = array_column(CommonHelper::getUserProject(),'ProjectID');
        return $query->whereIn('ProjectID', $projectIds);
    }

}
