<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public $timestamps = false;
    protected $table = 'Offer';
    protected $primaryKey = 'ID';
}
