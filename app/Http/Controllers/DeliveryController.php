<?php

namespace App\Http\Controllers;

use App\Model\DeliveryCharge;
use App\Model\Project;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $delivery_charge = DeliveryCharge::permitted()->get();
        return view('delivery_charge.delivery_list',compact('delivery_charge'));
    }

    public function deliveryCreate(){
        $projects = Project::permitted()->get();
        return view('delivery_charge.delivery_create',compact('projects'));
    }

    public function deliveryStore(Request $request){
        $this->validate($request,[
            'ProjectID' => 'required',
            'DeliveryCharge' => 'required',
        ]);

        $delivery_charge = new DeliveryCharge();
        $delivery_charge->ProjectID = $request->ProjectID;
        $delivery_charge->DeliveryCharge = $request->DeliveryCharge;
        $delivery_charge->Limit = $request->Limit;
        $delivery_charge->DestinationName = $request->DestinationName;
        $delivery_charge->CreatedAt = Carbon::now();
        $delivery_charge->UpdatedAt = Carbon::now();
        $delivery_charge->save();

        Toastr::success('Delivery Charge Added successfully)' ,'Success');
        return redirect()->route('delivery.index');
    }

    public function deliveryEdit($id){
        $projects = Project::permitted()->get();
        $delivery_charge = DeliveryCharge::find($id);
        return view('delivery_charge.delivery_edit',compact('projects','delivery_charge'));
    }

    public function deliveryUpdate(Request $request,$id){
        $this->validate($request,[
            'ProjectID' => 'required',
            'DeliveryCharge' => 'required',
        ]);

        $delivery_charge = DeliveryCharge::find($id);
        $delivery_charge->ProjectID = $request->ProjectID;
        $delivery_charge->DeliveryCharge = $request->DeliveryCharge;
        $delivery_charge->Limit = $request->Limit;
        $delivery_charge->DestinationName = $request->DestinationName;
        $delivery_charge->CreatedAt = Carbon::now();
        $delivery_charge->UpdatedAt = Carbon::now();
        $delivery_charge->save();

        Toastr::success('Delivery Charge Updated successfully)' ,'Success');
        return redirect()->route('delivery.index');
    }
}
