<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use App\Model\Invoice;
use App\Model\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

       //dd(Auth::user()->project[0]->ProjectID);
        $latest_order = Invoice::permitted()->orderBy('InvoiceNo', 'desc')->permitted()->take(10)->get();
        $total_order = Invoice::permitted()->get();
        $total_delivered = Invoice::where('InvStatusID',3)->permitted()->get();
        $total_pending = Invoice::where('InvStatusID',1)->permitted()->get();
        $total_customer = Customer::permitted()->get();

        return view('dashboard',compact('latest_order','total_order','total_delivered','total_pending','total_customer'));
    }
}
