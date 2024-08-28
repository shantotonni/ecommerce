<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Http\Controllers\CommonHelper;
use App\Model\Invoice;
use App\Model\InvoiceDetail;
use App\Model\InvoiceStatus;
use App\Model\Product;
use App\Model\UserProject;
use App\Model\UserUpazilla;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $status = InvoiceStatus::all();
        $total = Invoice::query()->permitted()->count();
        $processing = Invoice::query()->permitted()->whereHas('invoiceStatus',function ($q){
            $q->where('InvStatus','processing');
        })->count();
        $delivered = Invoice::query()->permitted()->whereHas('invoiceStatus',function ($q){
            $q->where('InvStatus','delivered');
        })->count();
        $cancel = Invoice::query()->permitted()->whereHas('invoiceStatus',function ($q){
            $q->where('InvStatus','cancel');
        })->count();
        return view('order.order_list',compact('status','total','processing','delivered','cancel'));
    }

    public function list(Request $request){
        if (request()->ajax()){

            $order = Invoice::query()->with('invoiceStatus','vat')->permitted();
            if ($request->has('status_id')){
                if (!empty($request->status_id)){
                    $order = $order->where('InvStatusID', $request->status_id);
                    if (!empty($request->from_date && !empty($request->to_date))){
                        $from = $request->from_date;
                        $to = $request->to_date;
                        $order = $order->whereBetween('InvoiceDate', [$from,$to]);
                    }else{
                        $order = $order;
                    }
                }else{
                    if (!empty($request->from_date && !empty($request->to_date))){
                        $from = $request->from_date;
                        $to = $request->to_date;
                        $order = $order->whereBetween('InvoiceDate', [$from,$to]);
                    }
                }
            }else{
                if (!empty($request->from_date && !empty($request->to_date))){
                    $from = $request->from_price;
                    $to = $request->to_price;
                    $order = $order->whereBetween('InvoiceDate', [$from,$to]);
                }else{
                    $order = $order;
                }
            }

            $data = DataTables::eloquent($order)
                ->order(function ($query) {
                  $query->orderBy('InvoiceNo', 'desc');
                })
                ->addColumn('InvoiceNo', function ($data){
                    return $data->InvoiceNo;
                })
                ->addColumn('DateOfBirth', function ($data){
                    return $data->DateOfBirth;
                })
                ->addColumn('InvoiceDate', function ($data){
                    return $data->InvoiceDate ;
                })
                ->addColumn('CustomerName', function ($data){
                    return $data->CustomerName;
                })
                ->addColumn('CustomerMobileNo', function ($data){
                    return $data->CustomerMobileNo;
                })
                ->addColumn('CustomerID', function ($data){
                    return $data->CustomerID;
                })
                ->addColumn('TotalAmount', function ($data){
                    return $data->TotalAmount .' TK';
                })
//                ->addColumn('DiscountAmount', function ($data){
//                    return number_format($data->DiscountAmount,2) .' TK';
//                })
                ->addColumn('VATAmount', function ($data){
                    return $data->vat->sum('VAT') .' TK';
                })
                ->addColumn('GrandTotal', function ($data){
                    return $data->GrandTotal .' TK';
                })
                ->addColumn('Status', function ($data){
                    return $data->invoiceStatus ? $data->invoiceStatus->InvStatus:'';
                })
                ->addColumn('action', function ($data){
                    $buttons='';
                    $buttons .= '<a class="btn btn-outline-warning btn-sm" href="'.route('order.details', $data->InvoiceNo).'" data-toggle="tooltip" title="View Order Details"><i class="fa fa-eye"></i></a>';
                    $buttons .= '<button type="button" class="btn btn-outline-success btn-sm" id="'.$data->InvoiceNo.'" onclick="addDeliveryCharge(this.id)" data-toggle="tooltip" title="Add Delivery Charge">Add DC</button>';
                    $buttons .= '<button type="button" class="btn btn-outline-primary btn-sm" id="'.$data->InvoiceNo.'" onclick="addDiscount(this.id)" data-toggle="tooltip" title="Add Discount">Add Discount</button>';
                    $buttons .= '<a class="btn btn-outline-danger btn-sm" href="'.route('order.delete', $data->InvoiceNo).'" data-toggle="tooltip" title="View Order Details" onclick="return confirm();"><i class="fa fa-trash"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);

            return $data;
        }
    }

    public function thanaWiseOrder(){
        $user_thana = UserUpazilla::where('UserId',Auth::user()->UserId)->pluck('ThanaCode')->toArray();
        $status = InvoiceStatus::all();
        $total = Invoice::query()->whereIn('ThanaCode',$user_thana)->permitted()->count();
        $processing = Invoice::query()->whereIn('ThanaCode',$user_thana)->permitted()->whereHas('invoiceStatus',function ($q){
            $q->where('InvStatus','processing');
        })->count();
        $delivered = Invoice::query()->whereIn('ThanaCode',$user_thana)->permitted()->whereHas('invoiceStatus',function ($q){
            $q->where('InvStatus','delivered');
        })->count();
        $cancel = Invoice::query()->whereIn('ThanaCode',$user_thana)->permitted()->whereHas('invoiceStatus',function ($q){
            $q->where('InvStatus','cancel');
        })->count();
        return view('order.thana_wise_order_list',compact('status','total','processing','delivered','cancel'));
    }

    public function thanaWiseOrderList(Request $request){
        if (request()->ajax()){
            $user_thana = UserUpazilla::where('UserId',Auth::user()->UserId)->pluck('ThanaCode')->toArray();

            $order = Invoice::query()->whereIn('ThanaCode',$user_thana)->with('invoiceStatus','vat')->permitted();
            if ($request->has('status_id')){
                if (!empty($request->status_id)){
                    $order = $order->where('InvStatusID', $request->status_id);
                    if (!empty($request->from_date && !empty($request->to_date))){
                        $from = $request->from_date;
                        $to = $request->to_date;
                        $order = $order->whereBetween('InvoiceDate', [$from,$to]);
                    }else{
                        $order = $order;
                    }
                }else{
                    if (!empty($request->from_date && !empty($request->to_date))){
                        $from = $request->from_date;
                        $to = $request->to_date;
                        $order = $order->whereBetween('InvoiceDate', [$from,$to]);
                    }
                }
            }else{
                if (!empty($request->from_date && !empty($request->to_date))){
                    $from = $request->from_price;
                    $to = $request->to_price;
                    $order = $order->whereBetween('InvoiceDate', [$from,$to]);
                }else{
                    $order = $order;
                }
            }

            $data = DataTables::eloquent($order)
                ->order(function ($query) {
                  $query->orderBy('InvoiceNo', 'desc');
                })
                ->addColumn('InvoiceNo', function ($data){
                    return $data->InvoiceNo;
                })
                ->addColumn('InvoiceDate', function ($data){
                    return $data->InvoiceDate ;
                })
                ->addColumn('CustomerName', function ($data){
                    return $data->CustomerName;
                })
                ->addColumn('CustomerMobileNo', function ($data){
                    return $data->CustomerMobileNo;
                })
                ->addColumn('CustomerID', function ($data){
                    return $data->CustomerID;
                })
                ->addColumn('TotalAmount', function ($data){
                    return $data->TotalAmount .' TK';
                })
//                ->addColumn('DiscountAmount', function ($data){
//                    return number_format($data->DiscountAmount,2) .' TK';
//                })
                ->addColumn('VATAmount', function ($data){
                    return $data->vat->sum('VAT') .' TK';
                })
                ->addColumn('GrandTotal', function ($data){
                    return $data->GrandTotal .' TK';
                })
                ->addColumn('Status', function ($data){
                    return $data->invoiceStatus ? $data->invoiceStatus->InvStatus:'';
                })
                ->addColumn('action', function ($data){
                    $buttons='';
                    $buttons .= '<a class="btn btn-outline-warning btn-sm" href="'.route('order.details', $data->InvoiceNo).'" data-toggle="tooltip" title="View Order Details"><i class="fa fa-eye"></i></a>';
                    $buttons .= '<button type="button" class="btn btn-outline-success btn-sm" id="'.$data->InvoiceNo.'" onclick="addDeliveryCharge(this.id)" data-toggle="tooltip" title="Add Delivery Charge">Add DC</button>';
                    $buttons .= '<button type="button" class="btn btn-outline-primary btn-sm" id="'.$data->InvoiceNo.'" onclick="addDiscount(this.id)" data-toggle="tooltip" title="Add Discount">Add Discount</button>';
//                    $buttons .= '<a class="btn btn-outline-danger btn-sm" href="'.route('order.delete', $data->InvoiceNo).'" data-toggle="tooltip" title="View Order Details" onclick="return confirm();"><i class="fa fa-trash"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);

            return $data;
        }
    }

    public function exportOrderList(Request $request) {

        $projectIds = array_column(CommonHelper::getUserProject(),'ProjectID');
        $title = "Order Details";

        $invoices = Invoice::with('invoiceDetail','paymentMethod')
            ->whereBetween('InvoiceDate', [$request->fdate,$request->tdate])
            ->whereIn('ProjectID', $projectIds);
            if ($request->status !=0){
                $invoices->where('InvStatusID', $request->status);
            }

        $invoices = $invoices->orderBy('InvoiceNo','desc')->get();

        $result = [];

        foreach ($invoices as $invoice){
            foreach ($invoice->invoiceDetail as $value){
                $result[] = [
                    'Invoice No or Transaction Id' => $invoice->InvoiceNo,
                    'Product Code' => $value->product->ProductCodeSystem,
                    'Invoice Date or order Date' => $invoice->InvoiceDate,
                    'Customer Name' => $invoice->CustomerName,
                    'Customer MobileNo' => $invoice->CustomerMobileNo,
                    'Delivery Address' => $invoice->DeliveryAddress,
                    'District' => $invoice->DistrictName,
                    'Thana' => $invoice->ThanaName,
                    'Product Name' => $value->ProductName,
                    'Item Per Unit Price' => $value->ItemPrice,
                    'Order Quantity' => $value->Quantity,
                    'Delivery Charge' => $invoice->DeliveryCharge,
                    'VAT' => $value->VAT,
                    'Discount Amount' => $invoice->DiscountAmount,
                    'Payment Method' => isset($invoice->paymentMethod) ? $invoice->paymentMethod->PaymentMethodName : '',
                    'Total Payable' => (($value->ItemFinalPrice * $value->Quantity ) - $invoice->DiscountAmount),
                    'Order Status' => $invoice->invoiceStatus->InvStatus,
                ];
            }
        }

       $this->exportexcel($result,$title);
    }

    public function orderDetails($id){
        $invoice_status = InvoiceStatus::all();
        $invoice = Invoice::where('InvoiceNo',$id)->with('invoiceDetail','customer','invoiceStatus')->first();
        return view('order.order_details',compact('invoice','invoice_status'));
    }

    public function orderInvoicePrint($id){

        $invoice = Invoice::where('InvoiceNo',$id)->with('invoiceDetail')->first();
        return view('order.invoice_print',compact('invoice'));
       // $pdf = PDF::loadView('order.invoice_print', compact('invoice'), [], 'utf-8');
        //return $pdf->stream('Invoice.pdf');
    }

    public function orderStatusChange(Request $request,$id){

        $invoice = Invoice::where('InvoiceNo',$id)->with('invoiceDetail')->first();
        $invoice->InvStatusID = $request->status_id;
        $invoice->save();
        return redirect()->back();
    }

    public function orderDelete($id){
        $invoice = Invoice::where('InvoiceNo',$id)->first();
        if ($invoice) {
            $invoice_details = InvoiceDetail::where('InvoiceNo',$invoice->InvoiceNo)->get();
            foreach ($invoice_details as $value){
                $value->delete();
            }
        }
        $invoice->delete();
        Toastr::success('Invoice Deleted successfully)' ,'Success');
        return redirect()->route('order.index',$id);
    }

    public function orderDetailsEdit($invoiceNo,$productCode){
        $product = Product::permitted()->where('ProductCode',$productCode)->orderBy('ProductCode','desc')->first();
        $invoice_details = InvoiceDetail::where('InvoiceNo',$invoiceNo)->where('ProductCode',$productCode)->first();
        return view('order.order_details_edit',compact('invoice_details','product','invoiceNo','productCode'));
    }

    public function orderDetailsUpdate(Request $request){

        $product = Product::where('ProductCode',$request->product_code)->first();
        $invoice = Invoice::where('InvoiceNo',$request->invoice_no)->first();
        $invoice_details = InvoiceDetail::where('InvoiceNo',$request->invoice_no)->where('ProductCode',$request->product_code)->first();

        $old_price = $invoice_details->ItemFinalPrice * $request->old_quantity;
        $new_price = $invoice_details->ItemFinalPrice * $request->Quantity;

        InvoiceDetail::where('InvoiceNo',$request->invoice_no)->where('ProductCode',$request->product_code)->update([
            'Quantity'=>$request->Quantity,
            'DeliveryQuantity'=>$request->Quantity,
        ]);

        Invoice::where('InvoiceNo',$request->invoice_no)->update([
            'TotalAmount'=>($invoice->TotalAmount -$old_price) + $new_price,
            'GrandTotal'=>($invoice->TotalAmount -$old_price) + $new_price,
        ]);

        Toastr::success('Product Changed successfully)' ,'Success');
        return redirect()->back();
    }

    public function orderDetailsDelete($invoiceNo,$productCode){
        $invoice = Invoice::where('InvoiceNo',$invoiceNo)->first();
        $invoice_details = DB::table('InvoiceDetails')->where('InvoiceNo', $invoiceNo)->where('ProductCode', $productCode)->first();

        $invoice->TotalAmount = $invoice->TotalAmount - ($invoice_details->ItemFinalPrice * $invoice_details->Quantity);
        $invoice->GrandTotal = $invoice->GrandTotal - ($invoice_details->ItemFinalPrice * $invoice_details->Quantity);
        $invoice->save();

        DB::table('InvoiceDetails')->where('InvoiceNo', $invoiceNo)->where('ProductCode', $productCode)->delete();
        Toastr::success('Invoice Deleted successfully)' ,'Success');
        return redirect()->back();
    }

    public function orderDeliveryChangeAdd(Request $request){
        $invocie = Invoice::where('InvoiceNo',$request->InvoiceNo)->first();
        $invocie->GrandTotal = $invocie->GrandTotal - $invocie->DeliveryCharge;
        $invocie->GrandTotal = $invocie->GrandTotal + $request->DeliveryCharge;
        $invocie->DeliveryCharge = $request->DeliveryCharge;
        $invocie->save();

        Toastr::success('Added Delivery Charge successfully)' ,'Success');
        return redirect()->route('order.index');

    }

    public function orderDiscountAdd(Request $request){

        $invocie = Invoice::where('InvoiceNo',$request->InvoiceNo)->first();
        $invocie->DiscountAmount = $invocie->DiscountAmount + $request->DiscountAmount;
        $invocie->save();

        Toastr::success('Added Discount Successfully)' ,'Success');
        return redirect()->route('order.index');
    }

    public function exportexcel($result,$filename){

        for($i=0; $i<count($result); $i++){
            unset($result[$i]['PageNo']);
        }

        $arrayheading[0] = array_keys($result[0]);
        $result = array_merge($arrayheading, $result);

        header("Content-Disposition: attachment; filename=\"{$filename}.xls\"");
        header("Content-Type: application/vnd.ms-excel;");
        header("Pragma: no-cache");
        header("Expires: 0");
        $out = fopen("php://output", 'w');

        foreach ($result as $data)
        {
            fputcsv($out, $data,"\t");
        }
        fclose($out);
        exit();
    }

    public function addOrder(){
        $products = Product::with(['stock', 'category', 'subcategory']);
        $products->permittedProject();
        $products = $products->orderBy('ProductCode','desc')->get();
        $data['products'] = $products;
        $data['districts'] = DB::select(DB::raw('SELECT * FROM vDistrict'));

        return view('order.add_order',$data);
    }

    public function storeOrder(Request $request){

        $project_id = UserProject::where('UserId',Auth::user()->UserId)->first()->ProjectID;
        $ip = $_SERVER['REMOTE_ADDR'];

        $district = DB::select(DB::raw("SELECT * FROM vDistrict where DistrictCode='$request->District'"));
        $thana = DB::select(DB::raw("SELECT * FROM vUpazilla where UpazillaCode='$request->Thana'"));

        $ProductCode = $request->ProductCode;

        $total_ItemFinalPrice = 0;
        foreach ($ProductCode as $ProductId){
            $Product = Product::where('ProductCode',$ProductId)->first();
            $total_ItemFinalPrice +=  $Product->ItemFinalPrice;
        }

        $invoice = new Invoice();
        $invoice->ProjectID = $project_id;
        $invoice->InvoicePeriod = Carbon::now()->format('Ym');
        $invoice->InvoiceDate = Carbon::now();
        $invoice->CustomerID = isset(Auth::user()->CustomerID) ? Auth::user()->CustomerID : '';
        $invoice->CouponID = isset($CouponID) ? $CouponID : null;
        $invoice->CustomerName = $request->FirstName.' '.$request->LastName;
        $invoice->CustomerMobileNo = $request->CustomerMobileNo;
        $invoice->CustomerEmail = $request->CustomerEmail;
        $invoice->AddressID = isset($request->AddressID) ? $request->AddressID : '';
        $invoice->DistrictCode = $district[0]->DistrictCode;
        $invoice->DistrictName = $district[0]->DistrictName;
        $invoice->ThanaCode = $thana[0]->UpazillaCode;
        $invoice->ThanaName = $thana[0]->UpazillaName;

        $invoice->DeliveryAddress = $request->DeliveryAddress;

        $invoice->DiscountAmount = isset($request->DiscountAmount) ? $request->DiscountAmount : 0;
        $invoice->TotalAmount = $total_ItemFinalPrice;
        $invoice->GrandTotal = $total_ItemFinalPrice - (isset($request->DiscountAmount) ? $request->DiscountAmount : 0);
        $invoice->DiscountID = 1;
        $invoice->DeliveryCharge = $request->DeliveryCharge;
        $invoice->Remark = 'Remark';
        $invoice->SupplierID = 1;
        $invoice->PaymentMethodId = 1;
        $invoice->IpAddress = $ip;
        $invoice->InvStatusID = 1;
        $invoice->ShipDate = '';
        $invoice->ShippersID = '';

        if ($invoice->save()){
            foreach($ProductCode as $ProductId){
                $Product = Product::where('ProductCode',$ProductId)->first();
                $invoice_details =new InvoiceDetail();
                $invoice_details->InvoiceNo = $invoice->InvoiceNo;
                $invoice_details->ProductCode = $Product->ProductCode;
                $invoice_details->ProductName = $Product->ProductName;
                $invoice_details->Quantity = 1;
                $invoice_details->DeliveryQuantity = 1;
                $invoice_details->ItemPrice = $Product->ItemFinalPrice;
                $invoice_details->VAT = 0;
                $invoice_details->Discount = isset($request->DiscountAmount) ? $request->DiscountAmount : 0;
                $invoice_details->ItemFinalPrice = $Product->ItemFinalPrice;
                $invoice_details->save();
            }

            Toastr::success('Order Successfully Completed' ,'Success');
            return redirect()->back();
        }

}

    public function couponOrder(){
        $status = InvoiceStatus::all();
        return view('order.coupon_order',compact('status'));
    }

    public function getCouponOrder(Request $request){
        if (request()->ajax()){
            $order = Invoice::query()->with('invoiceStatus','vat')->whereHas('coupon',function ($query){
                $query->where('Business','H');
            })->whereNotNull('CouponID')->permitted();
            if (!empty($request->from_date && !empty($request->to_date))){
                $from = $request->from_price;
                $to = $request->to_price;
                $order = $order->whereBetween('InvoiceDate', [$from,$to]);
            }else{
                $order = $order;
            }

            $data = DataTables::eloquent($order)
                ->order(function ($query) {
                    $query->orderBy('InvoiceNo', 'desc');
                })
                ->addColumn('InvoiceNo', function ($data){
                    return $data->InvoiceNo;
                })
                ->addColumn('InvoiceDate', function ($data){
                    return $data->InvoiceDate ;
                })
                ->addColumn('CustomerName', function ($data){
                    return $data->CustomerName;
                })
                ->addColumn('CustomerMobileNo', function ($data){
                    return $data->CustomerMobileNo;
                })
                ->addColumn('CustomerID', function ($data){
                    return $data->CustomerID;
                })
                ->addColumn('TotalAmount', function ($data){
                    return $data->TotalAmount .' TK';
                })
//                ->addColumn('DiscountAmount', function ($data){
//                    return number_format($data->DiscountAmount,2) .' TK';
//                })
                ->addColumn('VATAmount', function ($data){
                    return $data->vat->sum('VAT') .' TK';
                })
                ->addColumn('GrandTotal', function ($data){
                    return $data->GrandTotal .' TK';
                })
                ->addColumn('Status', function ($data){
                    return $data->invoiceStatus ? $data->invoiceStatus->InvStatus:'';
                })
                ->addColumn('action', function ($data){
                    $buttons='';
                    $buttons .= '<a class="btn btn-outline-warning btn-sm" href="'.route('order.details', $data->InvoiceNo).'" data-toggle="tooltip" title="View Order Details"><i class="fa fa-eye"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);

            return $data;
        }
    }

    public function addAdditionalProduct($InvoiceNo){
        $products = Product::permitted()->where('ProductStatus','Y')->orderBy('ProductCode','desc')->get();
        return view('order.order_product_add',compact('products','InvoiceNo'));
    }

    public function storeAdditionalProduct(Request $request){

        $product = Product::where('ProductCode',$request->product_id)->first();
        $Invoice = Invoice::where('InvoiceNo',$request->invoice_no)->first();

        DB::beginTransaction();
        try {
            $amount = $product->ItemFinalPrice * $request->Quantity;
            $Invoice->TotalAmount = $Invoice->TotalAmount + $amount;
            $Invoice->GrandTotal = $Invoice->GrandTotal + $amount;

            if ($Invoice->save()) {
                $Invoice_details = new InvoiceDetail();
                $Invoice_details->InvoiceNo = $request->invoice_no;
                $Invoice_details->ProductCode = $request->product_id;
                $Invoice_details->ProductName = $product->ProductName;
                $Invoice_details->Quantity = $request->Quantity;
                $Invoice_details->DeliveryQuantity = $request->Quantity;
                $Invoice_details->ItemPrice = $product->ItemPrice;
                $Invoice_details->VAT = $product->VAT;
                $Invoice_details->Discount = $product->Discount;
                $Invoice_details->ItemFinalPrice = $product->ItemFinalPrice;
                $Invoice_details->save();
                DB::commit();

                Toastr::success('Product Added successfully)' ,'Success');
                return redirect()->back();
            }
        }catch (\Exception $e){
            DB::rollback();
        }
    }
}
