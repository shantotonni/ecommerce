<?php

namespace App\Http\Controllers;

use App\Model\Offer;
use App\Model\OfferProduct;
use App\Model\Product;
use App\Model\Project;
use App\Model\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function offerCategory()
    {
        $products = Product::query();
        $products->permittedProject();
        $products = $products->orderBy('ProductCode','desc')->get();

        return view('offer.create', compact('products'));
    }

    public function offerCategorySubmit(Request $request)
    {

        $id = $request->input('id');
        $offer = new Offer();
        if ($id != '') {
            $offer = $offer->find($id);
            $offer->UpdatedAt = date('Y-m-d H:i:s');
        } else {
            $offer->CreatedAt = date('Y-m-d H:i:s');
        }

        $offer->OfferName = $request->input('OfferName');
        $offer->OfferDescription = $request->input('OfferDescription');

        if (isset($request->image)) {
            $maxWidth = config('app.image')['offer_image']['max_width'];
            $maxHeight = config('app.image')['offer_image']['max_height'];
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|dimensions:max_width=' . $maxWidth . ',' . 'max_height=' . $maxHeight,
            ]);
            $imageName = CommonHelper::uploadImage($request->image, 'offer_image');
            $offer->OfferImage = $imageName;
        }

        if (isset($request->bannerImage)) {
            $maxWidth = config('app.image')['offer_image']['max_width'];
            $maxHeight = config('app.image')['offer_image']['max_height'];
            $request->validate([
                'bannerImage' => 'required|image|mimes:jpeg,png,jpg|dimensions:max_width=' . $maxWidth . ',' . 'max_height=' . $maxHeight,
            ]);
            $imageName = CommonHelper::uploadImage($request->bannerImage, 'offer_image');
            $offer->OfferBanner = $imageName;
        }

        if ($status = $offer->save()) {
            $productCodes = $request->ProductCodes;
            foreach($productCodes as $p){
                $newProd = new OfferProduct();
                $newProd->OfferID = $offer->ID;
                $newProd->ProductCode = $p;
                $newProd->CreatedAt = Carbon::now();
                $newProd->save();

            }

            Toastr()->success('success');
            return redirect('offer-list');
        } else {
            Toastr()->error('error');
            return redirect()->back();
        }
    }

    public function offerList(Request $request)
    {
        $data = [];
        $data['featureName'] = "Offer Category";
        $data['actionTitle'] = "Add";
        $data['action'] = 'offer/offer-category';
        $data['imageUrl'] = url(config('app.image')['offer_image']['upload_path']);


        $offers = Offer::orderBy('ID','desc')->paginate(10);
        $data['offers'] = $offers;
        //dd($data['products']);

        return view('offer/offer_list', $data);
    }

    public function offerEdit($ID)
    {
        $products = Product::query();
        $products->permittedProject();
        $products = $products->orderBy('ProductCode','desc')->get();
        $offer = Offer::where('ID',$ID)->first();
        $offer_product = OfferProduct::where('OfferID',$ID)->pluck('ProductCode')->toArray();
        return view('offer.edit',compact('offer','products','offer_product'));
    }

    public function offerUpdate(Request $request, $ID){

        $offer = Offer::find($ID);
        $offer->OfferName = $request->OfferName;
        $offer->OfferDescription = $request->OfferDescription;
        $offer->Active = $request->Active;

        if ($request->has('image')) {
            $imageName = CommonHelper::uploadImage($request->image, 'offer_image');
            $offer->OfferImage = $imageName;
        }

        if ($request->has('bannerImage')) {
            $imageName = CommonHelper::uploadImage($request->bannerImage, 'offer_image');
            $offer->OfferBanner = $imageName;
        }

        if ($offer->save()) {
            OfferProduct::where('OfferID',$ID)->delete();
            $productCodes = $request->ProductCodes;
            foreach ($productCodes as $p) {
                $newProd = new OfferProduct();
                $newProd->OfferID = $offer->ID;
                $newProd->ProductCode = $p;
                $newProd->CreatedAt = Carbon::now();
                $newProd->save();
            }
        }

        return redirect()->back();
    }
}
