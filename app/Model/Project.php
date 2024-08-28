<?php

namespace App\Model;

use App\Http\Controllers\CommonHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    protected $table='ProjectDetails';
    protected  $primaryKey = 'ProjectID';

    public function scopePermitted($query)
    {
        $projectIds = array_column(CommonHelper::getUserProject(),'ProjectID');
        return $query->whereIn('ProjectID', $projectIds);
    }
}
