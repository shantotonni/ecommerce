<?php

namespace App\Model;

use App\Http\Controllers\CommonHelper;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'Invoice';

    protected $primaryKey = 'InvoiceNo';

    public $timestamps = false;

    public function invoiceDetail(){

        return $this->hasMany('App\Model\InvoiceDetail', 'InvoiceNo','InvoiceNo');
    }

    public function customer(){

        return $this->belongsTo('App\Model\Customer', 'CustomerID','CustomerID');
    }

    public function invoiceStatus(){

        return $this->belongsTo('App\Model\InvoiceStatus', 'InvStatusID','InvStatusID');
    }

    public function paymentMethod(){

        return $this->belongsTo('App\Model\PaymentMethod', 'PaymentMethodId','PaymentMethodId');
    }
    public function coupon(){
        return $this->belongsTo('App\Model\Coupon', 'CouponID','CouponID');
    }

    public function scopePermitted($query)
    {
        $projectIds = array_column(CommonHelper::getUserProject(),'ProjectID');
        return $query->whereIn('ProjectID', $projectIds);
    }

    public function vat(){
        return $this->invoiceDetail();
    }


}
