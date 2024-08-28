<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    protected $table = 'UserProject';
    public $timestamps =  false;
    protected $fillable = ['UserId','ProjectID'];

    public function project() {
        return $this->belongsTo('App\Model\Project','ProjectID','ProjectID');
    }

    

}
