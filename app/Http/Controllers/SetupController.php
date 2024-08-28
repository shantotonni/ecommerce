<?php

namespace App\Http\Controllers;

use App\Model\Banner;
use App\Model\Category;
use App\Model\Project;
use App\Model\SubCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetupController extends Controller
{
    public function  __construct()
    {
        $this->middleware('auth');
    }

    public function bannerManage($id = null)
    {
        $data = [];
        $data['featureName'] = "Banner";
        $data['actionTitle'] = "Add";
        $data['action'] = 'banner-manage';
        $data['imageUrl'] = url(config('app.image')['banner']['upload_path']);
        $data['maxWidth'] = config('app.image')['banner']['max_width'];
        $data['maxHeight'] = config('app.image')['banner']['max_height'];
        if ($id != null) {
            $data['selectedBanner'] = Banner::where('BannerID', $id)
                ->first();
            $data['actionTitle'] = "Update";
        }
        $data['banners'] = Banner::permitted()->with('project')->get();
        $data['projects'] = Project::permitted()->get();
        return view('setup/banner_mange', $data);
    }

    public function bannerAdd(Request $request)
    {
        $id = $request->input('id');
        $banner = new Banner();
        if ($id != '') {
            $banner = $banner->find($id);
            $banner->EditedBy = Auth::user()->UserId;
            $banner->EditedDate = date('Y-m-d H:i:s');
            $banner->EditedIP = $_SERVER['REMOTE_ADDR'];
            $banner->EditedDeviceState = 'Unknown';
        } else {
            $banner->CreatedDate = date('Y-m-d H:i:s');
            $banner->CreatedIP = $_SERVER['REMOTE_ADDR'];
            $banner->CreatedDeviceState = 'Unknown';
        }
        $banner->ProjectID = $request->input('project');
        $banner->BannerName = $request->input('bannerName');
        $banner->Url = $request->input('url');
        $banner->Active = ($request->input('active')) ? 'Y' : 'N';
        $banner->CreatedBy = Auth::user()->UserId;


        if (isset($request->image) || $id == '') {
            $maxWidth = config('app.image')['banner']['max_width'];
            $maxHeight = config('app.image')['banner']['max_height'];
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|dimensions:max_width=' . $maxWidth . ',' . 'max_height=' . $maxHeight,
            ]);
            $imageName = CommonHelper::uploadImage($request->image, 'banner');
            $banner->BannerImageFile = $imageName;
        }
        if ($banner->save()) {
            Toastr()->success('success');
        } else {
            Toastr()->error('error');
        }
        return redirect()->back();
    }

    public function categoryManage($id = null)
    {
        $data = [];
        $data['featureName'] = "Category";
        $data['actionTitle'] = "Add";
        $data['action'] = 'category-manage';
        $data['imageUrl'] = url(config('app.image')['category']['upload_path']);
        $data['maxWidth'] = config('app.image')['category']['max_width'];
        $data['maxHeight'] = config('app.image')['category']['max_height'];
        if ($id != null) {
            $data['selectedCategory'] = Category::where('CategoryId', $id)->first();
            $data['actionTitle'] = "Update";
        }

        $data['categories'] = Category::permitted()->with('project')->orderBy('Order','asc')->get();
        $data['projects'] = Project::permitted()->get();

        return view('setup/category_mange', $data);

    }

    public function categoryAdd(Request $request){

        $id = $request->input('id');
        $category = new Category();
        if ($id != '') {
            $category = $category->find($id);
            $category->EditedBy = Auth::user()->UserId;
            $category->EditedDate = date('Y-m-d H:i:s');
            $category->EditedIP = $_SERVER['REMOTE_ADDR'];
            $category->EditedDeviceState = 'Unknown';
        } else {
            $category->CreatedBy = Auth::user()->UserId;
            $category->CreatedDate = date('Y-m-d H:i:s');
            $category->CreatedIP = $_SERVER['REMOTE_ADDR'];
            $category->CreatedDeviceState = 'Unknown';
        }
        $category->ProjectID = $request->input('project');
        $category->Category = $request->input('category');
        $category->CategoryIcon = $request->input('categoryIcon') ? $request->input('categoryIcon') : '';
        $category->CategoryDescription = $request->input('categoryDescription') ? $request->input('categoryDescription') : '';
        $category->CategoryMetaData = $request->input('categoryMetaData') ?  $request->input('categoryMetaData') : '';
        $category->CategoryMetaTitle = $request->input('CategoryMetaTitle') ?  $request->input('CategoryMetaTitle') : '';

        $category->Order = $request->input('Order') ?  $request->input('Order') : 1;

        $category->CategoryStatus = ($request->input('active')) ? 'Y' : 'N';
        $category->IsFeatured = ($request->input('isFeatured')) ? 'Y' : 'N';

        $delimiter = '-';
        $string = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $request->category);
        $string = preg_replace("/[\/_|+ -]+/", $delimiter, $string);

        try {
            $category->CategorySlug = $string;
        } catch (\Exception $e) {
            $category->CategorySlug = '';
        }

        if (isset($request->image)) {
            $maxWidth = config('app.image')['category']['max_width'];
            $maxHeight = config('app.image')['category']['max_height'];
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|dimensions:max_width=' . $maxWidth . ',' . 'max_height=' . $maxHeight,
            ]);
            $imageName = CommonHelper::uploadImage($request->image, 'category');
            $category->CategoryImage = $imageName;
        }
        if ($category->save()) {
            Toastr()->success('success');
        } else {
            Toastr()->error('error');
        }
        return redirect()->back();
    }

    public function subcategoryManage($categoryId, $id = null)
    {
        $data = [];
        $data['featureName'] = "Subcategory";
        $data['actionTitle'] = "Add";
        $data['action'] = 'subcategory-manage';
        $data['imageUrl'] = url(config('app.image')['subcategory']['upload_path']);
        $data['maxWidth'] = config('app.image')['subcategory']['max_width'];
        $data['maxHeight'] = config('app.image')['subcategory']['max_height'];
        $data['categoryId'] = $categoryId;
        if ($id != null) {
            $data['selectedSubcategory'] = SubCategory::where('CategoryId', $categoryId)->where('SubCategoryId', $id)
                ->first();
            $data['actionTitle'] = "Update";
        }
        $data['category'] = Category::with('project')
            ->where('CategoryId', $categoryId)->first();
        $data['subcategories'] = SubCategory::where('CategoryId', $categoryId)->get();
        $data['projects'] = Project::get();
        return view('setup/subcategory_mange', $data);
    }

    public function subcategoryAdd(Request $request)
    {
        $id = $request->input('id');
        $subcategory = new SubCategory();
        if ($id != '') {
            $subcategory = $subcategory->find($id);
            $subcategory->EditedBy = Auth::user()->UserId;
            $subcategory->EditedDate = date('Y-m-d H:i:s');
            $subcategory->EditedIP = $_SERVER['REMOTE_ADDR'];
            $subcategory->EditedDeviceState = 'Unknown';
        } else {
            $subcategory->CreatedBy = Auth::user()->UserId;
            $subcategory->CreatedDate = date('Y-m-d H:i:s');
            $subcategory->CreatedIP = $_SERVER['REMOTE_ADDR'];
            $subcategory->CreatedDeviceState = 'Unknown';
        }
        $subcategory->ProjectID = $request->input('projectID');
        $subcategory->CategoryId = $request->input('categoryId');
        $subcategory->SubCategory = $request->input('subCategory');
        $subcategory->SubCategoryIcon = $request->input('subCategoryIcon') ? $request->input('subCategoryIcon') : '';
        $subcategory->SubCategoryDescription = $request->input('subCategoryDescription') ? $request->input('subCategoryDescription') : '';
        $subcategory->SubCategoryMetaData = $request->input('subCategoryMetaData') ? $request->input('subCategoryMetaData') : '';

        $subcategory->SubCategoryStatus = ($request->input('active')) ? 'Y' : 'N';
        $delimiter = '-';
        $string = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $request->subCategory);
        $string = preg_replace("/[\/_|+ -]+/", $delimiter, $string);

        try {
            $subcategory->SubCategorySlug = $string;
        } catch (\Exception $e) {
            $subcategory->SubCategorySlug = '';
        }

        if (isset($request->image)) {
            $maxWidth = config('app.image')['subcategory']['max_width'];
            $maxHeight = config('app.image')['subcategory']['max_height'];
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|dimensions:max_width=' . $maxWidth . ',' . 'max_height=' . $maxHeight,
            ]);
            $imageName = CommonHelper::uploadImage($request->image, 'subcategory');
            $subcategory->SubCategoryImage = $imageName;
        }
        if ($subcategory->save()) {
            Toastr()->success('success');
        } else {
            Toastr()->error('error');
        }
        return redirect()->back();
    }

    public function categoryDelete($id){

        $category = Category::find($id);
        $cat_path ='uploads/category/';
        if ($category) {
            $sub_cat = SubCategory::where('CategoryId',$category->CategoryId)->get();
            foreach ($sub_cat as $value){
                $sub_path ='uploads/subcategory/';
                //code for remove old file
                if($value->SubCategoryImage != ''  && $value->SubCategoryImage != null){
                    $sub_cat_file_old = $sub_path.$value->SubCategoryImage;
                    if (file_exists($sub_cat_file_old)) {
                        unlink($sub_cat_file_old);
                    }
                }
                $value->delete();
            }

            if($category->CategoryImage != ''  && $category->CategoryImage != null){
                $cat_file_old = $cat_path.$category->CategoryImage;
                if (file_exists($cat_file_old)) {
                    unlink($cat_file_old);
                }
            }
            $category->delete();
        }

        Toastr::success('Category Deleted Successfully', 'Success');
        return redirect()->route('category.index');
    }

    public function subCategoryDelete($id){

        $sub_cat = SubCategory::where('SubCategoryId',$id)->first();
        $sub_path ='uploads/subcategory/';

        if($sub_cat->SubCategoryImage != ''  && $sub_cat->SubCategoryImage != null){
            $sub_cat_file_old = $sub_path.$sub_cat->SubCategoryImage;
            if (file_exists($sub_cat_file_old)) {
                unlink($sub_cat_file_old);
            }
        }

        $sub_cat->delete();
        Toastr::success('Sub Category Deleted Successfully', 'Success');
        return redirect()->back();
    }

    public function bannerdelete($id){

        $banner = Banner::where('BannerID',$id)->first();
        $banner_path ='uploads/banner/';

        if($banner->BannerImageFile != ''  && $banner->BannerImageFile != null){
            $sub_cat_file_old = $banner_path.$banner->BannerImageFile;
            if (file_exists($sub_cat_file_old)) {
                unlink($sub_cat_file_old);
            }
        }
        $banner->delete();
        Toastr::success('Banner Deleted Successfully', 'Success');
        return redirect()->back();
    }
}
