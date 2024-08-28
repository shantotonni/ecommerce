<?php

namespace App\Model;

use App\Http\Controllers\CommonHelper;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'Banner';
    protected $primaryKey = 'BannerID';
    public $timestamps = false;

    public function scopePermitted($query)
    {
        $projectIds = array_column(CommonHelper::getUserProject(),'ProjectID');
        return $query->whereIn('ProjectID', $projectIds);
    }

    public function project() {
        return $this->belongsTo('App\Model\Project','ProjectID','ProjectID');
    }
}
