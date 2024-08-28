<?php

namespace App\Model;

use App\Http\Controllers\CommonHelper;
use Illuminate\Database\Eloquent\Model;

class DeliveryCharge extends Model
{
    protected $table = 'DeliveryCharge';

    protected $primaryKey = 'DeliveryChargeId';

    public $timestamps = false;

    public function scopePermitted($query)
    {
        $projectIds = array_column(CommonHelper::getUserProject(),'ProjectID');
        return $query->whereIn('ProjectID', $projectIds);
    }
}
