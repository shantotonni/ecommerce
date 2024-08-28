<?php

namespace App\Model;

use App\Http\Controllers\CommonHelper;
use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model
{
    protected $table = 'guest_users';

    protected $primaryKey = 'id';

   // public $timestamps = false;

    public function scopePermitted($query)
    {
        $projectIds = array_column(CommonHelper::getUserProject(),'ProjectID');
        return $query->whereIn('ProjectID', $projectIds);
    }
}
