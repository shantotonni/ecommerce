<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\ReviewRating;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ReviewRatingController extends Controller
{
    public function reviewProduct(){
        $products = Product::permitted()->orderBy('ProductCode','desc')->paginate(10);
        return view('review.product_review_list',compact('products'));
    }

    public function productReviewDetails($id){
        $product = Product::where('ProductCode',$id)->with('reviews','review.customer')->first();
        return view('review.product_review_details',compact('product'));
    }

    public function productReviewApproved($id){
        $review = ReviewRating::where('ReviewId',$id)->first();
        if ($review->Approved == 1) {
            $review->Approved = 0;
        }else {
            $review->Approved = 1;
        }

        $review->save();

        Toastr::success('Review Status Change successfully :)' ,'Success');
        return redirect()->back();
    }
}
