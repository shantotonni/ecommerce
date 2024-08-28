<?php

namespace App\Http\Controllers;

use App\Model\Banner;
use App\Model\Business;
use App\Model\Category;
use App\Model\Product;
use App\Model\ProductImage;
use App\Model\Project;
use App\Model\Stock;
use App\Model\SubCategory;
use App\Model\UserBusiness;
use App\Model\UserProject;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    private $limit = 10;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function productManage($id = null)
    {
        $data = [];
        $data['featureName'] = "Product";
        $data['actionTitle'] = "Add";
        $data['action'] = 'product-manage';
        $data['imageUrl'] = url(config('app.image')['product']['upload_path']);
        $data['maxWidth'] = config('app.image')['product']['max_width'];
        $data['maxHeight'] = config('app.image')['product']['max_height'];
        if ($id != null) {
            $data['selectedProduct'] = Product::where('ProductCode', $id)->first();
            $data['actionTitle'] = "Update";
        }

        $data['projects'] = Project::permitted()->get();
        $data['businesses'] = CommonHelper::getUserBusiness();
        $data['categories'] = CommonHelper::getUserCategory();
        //dd($data['categories']);
        $permittedCategoryIds = !empty($data['categories']) ? array_column($data['categories'],'CategoryId') : [];
        $data['subCategories'] = SubCategory::get()->toArray();

        return view('product/product_mange', $data);
    }

    public function productAdd(Request $request){

        $id = $request->input('id');
        $product = new Product();
        if ($id != '') {
            $product = $product->find($id);
            $product->EditedBy = Auth::user()->UserId;
            $product->EditedDate = date('Y-m-d H:i:s');
            $product->EditedIP = $_SERVER['REMOTE_ADDR'];
            $product->EditedDeviceState = 'Unknown';
        } else {
            $product->CreatedBy = Auth::user()->UserId;
            $product->CreatedDate = date('Y-m-d H:i:s');
            $product->CreatedIP = $_SERVER['REMOTE_ADDR'];
            $product->CreatedDeviceState = 'Unknown';
        }
        $product->ProjectID = $request->input('project');
        $product->Business = $request->input('business');
        $product->ProductCodeSystem = $request->input('ProductCodeSystem') ? $request->input('ProductCodeSystem') : '';
        $product->ProductVideo = $request->input('ProductVideo') ? $request->input('ProductVideo') : '';
        $product->CategoryId = $request->input('categoryId');
        $product->SubCategoryId = $request->input('subCategoryId');
        $product->ProductName = $request->input('productName');
        $product->ProductDetails = $request->input('productDetails') ? $request->input('productDetails') : '';
        $product->ProductMetaData = $request->input('productMetaData') ? $request->input('productMetaData') : '';

        $product->ItemPrice = round($request->input('itemPrice'));
        $product->VAT = $request->input('vat');
        $product->DiscountType = $request->input('discountType');
        $product->DiscountType = $request->input('discountType');
        $product->Discount = $request->input('discount');
        $product->ItemFinalPrice = round($request->input('itemFinalPrice'));
        $product->ProductStatus = ($request->input('active')) ? 'Y' : 'N';
        $product->ProductMetaTitle = $request->ProductMetaTitle;

        $delimiter = '-';
        $string = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $request->productName);
        $string = preg_replace("/[\/_|+ -]+/", $delimiter, $string);


        try {
            $product->ProductSlug = $string;
        } catch (\Exception $e) {
            $product->ProductSlug = '';
        }

        if (isset($request->image)) {
            $maxWidth = config('app.image')['product']['max_width'];
            $maxHeight = config('app.image')['product']['max_height'];
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|dimensions:max_width=' . $maxWidth . ',' . 'max_height=' . $maxHeight,
            ]);
            // $prefix=projectId_CategoryId_SubCategoryId
            $prefix = $product->ProjectID."_".$product->CategoryId."_".$product->SubCategoryId;
            $imageName = CommonHelper::uploadImage($request->image, 'product',$prefix);
            $product->ProductImageFileName = $imageName;
        }

        if ($status = $product->save()) {
            Toastr()->success('success');
            return redirect('product-list');
        } else {
            Toastr()->error('error');
            return redirect()->back();
        }

    }

    public function productList(Request $request)
    {
        $data = [];
        $data['featureName'] = "Product";
        $data['actionTitle'] = "Add";
        $data['action'] = 'product-manage';
        $data['imageUrl'] = url(config('app.image')['product']['upload_path']);

        $period = date('Ym');

        $products = Product::with(['stock', 'category', 'subcategory']);

        if ($request->input('project')) {
            $products->where('ProjectId', $request->input('project'));
            $data['selectedProject'] = $request->input('project');
        }
        if ($request->input('business')) {
            $products->where('Business', $request->input('business'));
            $data['selectedBusiness'] = $request->input('business');
        }
        if ($request->input('categoryId')) {
            $products->where('CategoryId', $request->input('categoryId'));
            $data['selectedCategoryId'] = $request->input('categoryId');
        }
        if ($request->input('subCategoryId')) {
            $products->where('SubCategoryId', $request->input('subCategoryId'));
            $data['selectedSubCategoryId'] = $request->input('subCategoryId');
        }
        if ($request->input('productName')) {
            $products->where('ProductName','like', '%' . $request->input('productName') . '%');
            $data['selectedProductName'] = $request->input('productName');
        }
        $products->permittedProject();
        $products = $products->orderBy('ProductCode','desc')->paginate($this->limit);
        $data['products'] = $products;
        //dd($data['products']);
        $data['projects'] = Project::permitted()->get()->toArray();
        $data['businesses'] = CommonHelper::getUserBusiness();
        $data['categories'] = CommonHelper::getUserCategory();
        $data['subCategories'] = SubCategory::get()->toArray();

        if(!isset($data['selectedProject']) && count($data['projects']) == 1) {
            $data['selectedProject'] = $data['projects'][0]['ProjectID'];
        }
        if(!isset($data['selectedBusiness']) && count($data['businesses']) == 1) {
            $data['selectedBusiness'] = $data['businesses'][0]['Business'];
        }

        return view('product/product_list', $data);
    }

    public function productMultipleImageCreate($id){
        $product = Product::where('ProductCode',$id)->with('productImage')->select('ProductCode','ProductName')->first();
        $imageUrl = url(config('app.image')['product_others']['upload_path']);
        return view('product.product_multiple_image_create',compact('product','imageUrl'));
    }

    public function productMultipleImageStore(Request $request,$id){

        if($request->hasFile('ImageFileName')){

            foreach ($request->ImageFileName as $photo) {
                $imageName = CommonHelper::uploadImage($photo, 'product_others');
                $product_image = new ProductImage();
                $product_image->ProductID = $id;
                $product_image->ImageFileName   = $imageName;
                $product_image->save();
            }
        }

        Toastr::success('Product Image Created successfully)' ,'Success');
        return redirect()->back();

    }

    public function productMultipleImageDelete($id){

        $product_image = ProductImage::find($id);
        $destinationPath = "uploads/product_others/";
        //code for remove old file
        if($product_image->ImageFileName != ''  && $product_image->ImageFileName != null){
            $file_old = $destinationPath.$product_image->ImageFileName;
            if (File::exists($file_old)) {
                unlink($file_old);
            }
        }
        $product_image->delete();

        Toastr::success('Product Image Deleted Successfully', 'Success');
        return redirect()->route('product.list');

    }

    public function productStockAdd(Request $request)
    {
        $period = date('Ym');
        $PreviousStock = Stock::where('ProjectID',$request->input('projectId'))
                        ->where('ProductCode',$request->input('productCode'))
                        //->where('Period',$period)
                        ->first();

        if($PreviousStock != null) {

            $PreviousStock->Opening = ($PreviousStock->Opening + $request->input('newQuantity'));
            $PreviousStock->save();

        } else {
            // New Add
            $stock = new Stock();
            $stock->ProjectID = $request->input('projectId');
            $stock->ProductCode = $request->input('productCode');
            $stock->Period = $period;
            $stock->Opening = $request->input('newQuantity');
            $stock->save();
        }

        Toastr::success('Stock Added successfully)' ,'Success');
        return redirect()->back();

    }

    public function productUpdatePrice(Request $request){
        $page = $request->page;
        $product = Product::where('productCode',$request->productCode)->first();
        $price = $request->price;
        $discount = $request->discount;

        $discount_amount = ($price * $discount) / 100;
        $new_final_amount = $price - $discount_amount;

        $product->ItemPrice = $price;
        $product->Discount = $discount;
        $product->ItemFinalPrice = $new_final_amount;
        $product->save();

        return redirect('product-list?page='.$page);
    }


}
