<?php

namespace App\Http\Controllers;

use App\Model\Invoice;
use App\Model\InvoiceStatus;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function orderReport(Request $request){

        $total_order = Invoice::query()->with('invoiceStatus')->select('Invoice.*')->permitted();
        $total_delivered = Invoice::query()->with('invoiceStatus')->select('Invoice.*')->permitted()->where('InvStatusID',3);
        $total_pending = Invoice::query()->with('invoiceStatus')->select('Invoice.*')->permitted()->where('InvStatusID',1);
        $total_processing = Invoice::query()->with('invoiceStatus')->select('Invoice.*')->permitted()->where('InvStatusID',2);
        $total_cancel = Invoice::query()->with('invoiceStatus')->select('Invoice.*')->permitted()->where('InvStatusID',4);
        $from = '';
        $to = '';

        if ($request->has('from_date') || $request->has('to_date')){

            $from = $request->from_date;
            $to = $request->to_date;
            $total_order = $total_order->whereBetween('InvoiceDate', [$from,$to]);
            $total_delivered = $total_delivered->whereBetween('InvoiceDate', [$from,$to]);
            $total_pending = $total_pending->whereBetween('InvoiceDate', [$from,$to]);
            $total_processing = $total_processing->whereBetween('InvoiceDate', [$from,$to]);
            $total_cancel = $total_cancel->whereBetween('InvoiceDate', [$from,$to]);

        }

        $total_order = $total_order->get();
        $total_delivered = $total_delivered->get();
        $total_pending = $total_pending->get();
        $total_processing = $total_processing->get();
        $total_cancel = $total_cancel->get();
        //dd(Auth::user()->project[0]->ProjectID);
        return view('report.order_report',compact('total_order','total_delivered','total_pending','total_cancel','total_processing','from','to'));
    }
}
