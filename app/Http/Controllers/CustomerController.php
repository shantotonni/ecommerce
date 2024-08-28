<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use App\Model\UserManager;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('customer.customer_list');
    }

    public function list(Request $request){
        if (request()->ajax()){

            $customer = Customer::query()->select('Customer.*')->permitted();

            $data = DataTables::eloquent($customer)
                ->order(function ($query) {
                    $query->orderBy('CustomerID', 'desc');
                })
                ->addColumn('CustomerID', function ($data){
                    return $data->CustomerID;
                })
                ->addColumn('CustomerFirstName', function ($data){
                    return $data->CustomerFirstName ;
                })
                ->addColumn('DateOfBirth', function ($data){
                    return $data->DateOfBirth ;
                })
                ->addColumn('CustomerLastName', function ($data){
                    return $data->CustomerLastName;
                })
                ->addColumn('CustomerMobileNo', function ($data){
                    return $data->CustomerMobileNo;
                })
                ->addColumn('CustomerEmail', function ($data){
                    return $data->CustomerEmail;
                })
                ->addColumn('CreatedDate', function ($data){
                    return $data->CreatedDate;
                })
                ->addColumn('Status', function ($data){
                    $badge = '';
                    if($data->Status == 1){
                        $badge .= '<span class="badge badge-success">Active</span>';
                    }else{
                        $badge .= '<span class="badge badge-warning">Inactive</span>';
                    }
                    return $badge;

                })
                ->addColumn('action', function ($data){
                    $buttons='';
                    $buttons .= '<a class="btn btn-outline-warning btn-sm" id="'.$data->CustomerID.'" onclick="customerDetails(this.id)" data-toggle="tooltip" title="View Order Details"><i class="fa fa-eye"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['Status','action'])
                ->make(true);

            return $data;
        }
    }

    public function details(Request $request){
        $customer = Customer::where('CustomerId',$request->CustomerId)->with('customerAddress')->first();
        return response()->json($customer);
    }

    public function changePassword(){
       return view('change_password');
    }

    public function changePasswordStore(Request $request){

        $validator = Validator::make($request->all(), [
            'previous_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ]);

        $current_password = Auth::User()->Password;

        if ($validator->passes()) {
            if(Hash::check($request->previous_password, $current_password))
            {
                if(Hash::check($request->password, $current_password)){
                    Toastr::error('New Password and Old Password can not be same' ,'Error');
                    return redirect()->back();
                }else{
                    $customer = UserManager::find(Auth::User()->UserId);
                    $customer->Password = bcrypt($request->password);
                    $customer->save();
                    Toastr::success('Password Change successfully :)' ,'Success');
                    return redirect()->back();
                }

            }else{
                Toastr::error('Previous Password Not Correct :)' ,'Error');
                return redirect()->back();
            }
        }

        return redirect()->back()->with(['error'=>$validator->errors()->all()]);


    }
}
