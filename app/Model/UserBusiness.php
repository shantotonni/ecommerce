<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserBusiness extends Model
{
    public $timestamps = false;
    protected $table = 'UserBusiness';
    protected $primaryKey = 'UserId';
    protected $fillable = [
        'ProjectID',
        'UserId',
        'Business',
    ];

    public $incrementing = false;

    public function project()
    {
        return $this->hasOne('App\Model\Project', 'ProjectID', 'ProjectID');
    }

    public function business() {
        return $this->belongsTo('App\Model\Business','Business','Business');
    }
}
