<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\Project;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function discountCreate(){
        $projects = Project::permitted()->get();
        $products = Product::permitted()->where('ProductStatus','Y')->orderBy('ProductCode','desc')->get();
        return view('discount_create',compact('products','projects'));
    }

    public function discountStore(Request $request){

        $this->validate($request,[
            'ProjectID'=>'required',
            'discountType'=>'required',
            'discount'=>'required',
            'product_id'=>'required',
        ]);


        if ($request->product_id[0] == 'all_products'){
            $products = Product::where('ProjectID',$request->ProjectID)->get();
            foreach ($products as $product){
                $discount_amount = (($product->ItemPrice * $request->discount)/100);
                $product->ItemFinalPrice = floor(($product->ItemPrice - $discount_amount));
                $product->Discount = $request->discount;
                $product->discountType = $request->discountType;
                $product->save();
            }
        }else{

            foreach ($request->product_id as $product_id){
                $product = Product::permitted()->where('ProjectID',$request->ProjectID)->where('ProductCode',$product_id)->first();
                $discount_amount = (($product->ItemPrice * $request->discount)/100);
                $product->ItemFinalPrice = floor(($product->ItemPrice - $discount_amount));
                $product->Discount = $request->discount;
                $product->discountType = $request->discountType;
                $product->save();
            }
        }

        Toastr()->success('Discount Added Successfully');
        return redirect()->back();



    }
}
