<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Coupon;
use App\Model\CouponProduct;
use App\Model\Product;
use App\Model\Project;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){

        $search = $request->search;
        $coupons = Coupon::permitted()->orderBy('CreatedAt','desc');
        if ($search){
            $coupons = $coupons->where('CouponCode',$search);
        }
        $coupons = $coupons->paginate(15);
        return view('coupon.index',compact('coupons'));
    }

    public function create(){
        $projects = Project::permitted()->get();
        $products = Product::permitted()->where('ProductStatus','Y')->orderBy('ProductCode','desc')->get();
        $categories = Category::permitted()->where('CategoryStatus','Y')->get();
        return view('coupon.create',compact('products','projects','categories'));
    }

    public function store(Request $request){

        $created_at = Carbon::now();

        $coupon = new Coupon();
        $coupon->ProjectId = $request->ProjectID;
        $coupon->CategoryId = $request->CategoryId;
        $coupon->CouponCode = $request->CouponCode;
        $coupon->CouponExpiredDate = $request->CouponExpiredDate;
        $coupon->CouponName = $request->CouponName;
        $coupon->CouponAmount = $request->CouponAmount;
        $coupon->Offer = $request->Offer;
        $coupon->OfferType = "percentage";
        $coupon->Limit = $request->Limit;
        $coupon->Status = $request->Status;
        $coupon->CreatedAt = $created_at;
        $coupon->UpdatedAt = $created_at;

        if ($coupon->save()) {
//            foreach ($request->product_id as $product_id){
//                $coupon_product = new CouponProduct();
//                $coupon_product->CouponID = $coupon->CouponID;
//                $coupon_product->ProductID = $product_id;
//                $coupon_product->CreatedAt = $created_at;
//                $coupon_product->UpdatedAt = $created_at;
//                $coupon_product->save();
//            }

            Toastr::success('Coupon Created successfully)' ,'Success');
            return redirect()->route('coupon.index');

        }
    }

    public function edit($id){
        $projects = Project::permitted()->get();
        $products = Product::permitted()->where('ProductStatus','Y')->orderBy('ProductCode','desc')->get();
        $coupon = Coupon::find($id);
        return view('coupon.edit',compact('coupon','products','projects'));
    }

    public function update(Request $request,$id){

        $created_at = Carbon::now();

        $coupon = Coupon::find($id);
        $coupon->ProjectId = $request->ProjectID;
        $coupon->CategoryId = $request->CategoryId;
        $coupon->CouponCode = $request->CouponCode;
        $coupon->CouponExpiredDate = $request->CouponExpiredDate;
        $coupon->CouponName = $request->CouponName;
        $coupon->CouponAmount = $request->CouponAmount;
        $coupon->Offer = $request->Offer;
        $coupon->OfferType = "percentage";
        $coupon->Limit = $request->Limit;
        $coupon->Status = $request->Status;
        $coupon->CreatedAt = $created_at;
        $coupon->UpdatedAt = $created_at;
        if ($coupon->save()) {

//            $coupon_product = CouponProduct::where('CouponID',$id)->get();
//            foreach ($coupon_product as $value){
//                $value->delete();
//            }
//
//            foreach ($request->product_id as $product_id){
//                $coupon_product = new CouponProduct();
//                $coupon_product->CouponID = $coupon->CouponID;
//                $coupon_product->ProductID = $product_id;
//                $coupon_product->CreatedAt = $created_at;
//                $coupon_product->UpdatedAt = $created_at;
//                $coupon_product->save();
//            }

            Toastr::success('Coupon Updated successfully)' ,'Success');
            return redirect()->route('coupon.index');

        }
    }

    public function delete($id){
        $coupon = Coupon::find($id);
       if ($coupon) {
           $coupon_product = CouponProduct::where('CouponID',$id)->get();
           foreach ($coupon_product as $value){
               $value->delete();
           }
       }
        $coupon->delete();
        Toastr::success('Coupon Deleted successfully)' ,'Success');
        return redirect()->route('coupon.index');
    }

    public function couponActiveInactive($id){
        $coupon = Coupon::find($id);
        if ($coupon->Status == 'active') {
            $coupon->Status ='inactive';
            $coupon->save();
            Toastr::success('Coupon Deactivate successfully)' ,'Success');
            return redirect()->route('coupon.index');
        }else {
            $coupon->Status ='active';
            $coupon->save();
            Toastr::success('Coupon Activate successfully)' ,'Success');
            return redirect()->route('coupon.index');
        }


    }
}
