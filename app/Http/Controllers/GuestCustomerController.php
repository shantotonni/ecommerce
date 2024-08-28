<?php

namespace App\Http\Controllers;

use App\Model\GuestUser;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GuestCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('guest_customer.customer_list');
    }

    public function list(Request $request){
        if (request()->ajax()){

            $customer = GuestUser::query()->select('guest_users.*')->permitted();

            $data = DataTables::eloquent($customer)
                ->order(function ($query) {
                    $query->orderBy('id', 'desc');
                })
                ->addColumn('id', function ($data){
                    return $data->id;
                })
                ->addColumn('customer_name', function ($data){
                    return $data->customer_name ;
                })
                ->addColumn('mobile', function ($data){
                    return $data->mobile;
                })
                ->addColumn('email', function ($data){
                    return $data->email;
                })
                ->addColumn('DeliveryAddress', function ($data){
                    return $data->DeliveryAddress;
                })
                ->addColumn('District', function ($data){
                    return $data->District;
                })
                ->addColumn('Thana', function ($data){
                    return $data->Thana;
                })
                ->addColumn('created_at', function ($data){
                    return $data->created_at;
                })
                ->addColumn('action', function ($data){
                    $buttons='';
                    $buttons .= '<a class="btn btn-outline-warning btn-sm" id="'.$data->id.'" onclick="guestCustomerDetails(this.id)" data-toggle="tooltip" title="View Order Details"><i class="fa fa-eye"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);

            return $data;
        }
    }

    public function details(Request $request){
        $customer = GuestUser::where('id',$request->CustomerId)->first();
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
