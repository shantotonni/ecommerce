<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $table = 'InvoiceDetails';

    protected $primaryKey = 'InvoiceNo';

    public $timestamps = false;

    public function product(){
        return $this->belongsTo('App\Model\Product', 'ProductCode','ProductCode');
    }

    public function invoice(){
        return $this->belongsTo('App\Model\Invoice', 'InvoiceNo','InvoiceNo');
    }
}
