<?php

namespace App\Exports;

use App\Http\Controllers\CommonHelper;
use App\Model\Invoice;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromQuery, WithHeadings
{
    private $fdate;
    private $tdate;
    private $status;

    public function __construct($fdate,$tdate,$status)
    {
        $this->fdate = $fdate;
        $this->tdate  = $tdate;
        $this->status  = $status;
    }

    public function query()
    {
        $projectIds = array_column(CommonHelper::getUserProject(),'ProjectID');

        $invoices = Invoice::with('invoiceDetail')
            ->whereBetween('InvoiceDate', [$this->fdate,$this->tdate])
            ->whereIn('ProjectID', $projectIds)->orderBy('InvoiceNo','asc')
            //->select('InvoiceNo','InvoiceDate','CustomerName','CustomerMobileNo','ProductName','ItemPrice','ItemFinalPrice')
            ->orWhere('InvStatusID', $this->status)->get();

        $result = [];


        foreach ($invoices as $invoice){
            foreach ($invoice->invoiceDetail as $value){
                $result[] = [
                    'InvoiceNo'=>$invoice->InvoiceNo,
                    'InvoiceDate'=>$invoice->InvoiceDate,
                    'CustomerName'=>$invoice->CustomerName,
                    'CustomerMobileNo'=>$invoice->CustomerMobileNo,
                    'ProductName'=>$value->ProductName,
                    'ItemPrice'=>$value->ItemPrice,
                    'ItemFinalPrice'=>$value->ItemFinalPrice,
                ];

            }
        }

        $final = collect($result);
      //  dd($final);

        return $final;

    }

    public function headings():array
    {
        return [
                "Invoice No",
                "Invoice Date",
                "Customer Name",
                "Customer MobileNo",
                "Product Name",
                "Item Price",
                "Item Final Price",
            ];
    }
}
