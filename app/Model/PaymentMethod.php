<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'PaymentMethod';

    protected $primaryKey = 'PaymentMethodId';

    public $timestamps = false;

}
