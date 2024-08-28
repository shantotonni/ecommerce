<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\UserBusiness;
use App\Model\UserMenu;
use App\Model\UserProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommonHelper extends Controller
{
    public static function getUserMenu(){
        if ($data = Session::get('userMenu')) {
            return $data;
        }
        $userId = Auth::user()->UserId;
        $userMenu = UserMenu::where('UserId', $userId)
            ->with(['menu' => function ($query) {
                $query->orderBy('MenuOrder');
            }])
            ->get()->groupBy('Menu.MenuName')->toArray();
        Session::put('userMenu', $userMenu);
        Session::save();
        return $userMenu;
    }

    public static function getUserBusiness(){
        if ($data = Session::get('userBusinesses')) {
            return $data;
        }
        $userId = Auth::user()->UserId;
        $userBusinesses = UserBusiness::with('business')->where('UserId', $userId)->get()->toArray();
        Session::put('userBusinesses', $userBusinesses);
        Session::save();
        return $userBusinesses;
    }

    public static function getUserProject(){

        if ($data = Session::get('userProject')) {
            return $data;
        }
        $userId = Auth::user()->UserId;
        $userProject = UserProject::with('project')->where('UserId', $userId)
            ->get()
            ->toArray();
        Session::put('userProject', $userProject);
        Session::save();
        return $userProject;
    }

    public static function uploadImage($image, $featureName = '', $prefix = ''){
        try {
            $imageUploadPath = 'uploads';
            if ($featureName != '') {
                $imageUploadPath = config('app.image')[$featureName]['upload_path'];
            }
            if (!file_exists($imageUploadPath)) {
                mkdir($imageUploadPath, 0777);
            }
            if ($prefix != '') {
                $prefix = $prefix . '_';
            }
            $imageName = $prefix . time() . uniqid() . '.' . $image->extension();
            $image->move($imageUploadPath, $imageName);
            return $imageName;
        } catch (\Exception $ex) {
            return null;
        }
    }

    public static function getUserCategory(){
        if (Session::get('userCategory')) {
            return Session::get('userCategory');
        }
        $userCategory = Category::permitted()->get()->toArray();
        Session::put('userCategory', $userCategory);
        Session::save();
        return $userCategory;
    }

    public static function hasAccessOnTheUser($userId){
        $permittedUserIds = self::getPermittedUserId();
        if (!in_array($userId, $permittedUserIds)) {
            return false;
        }
        return true;
    }

    public static  function getPermittedUserId(){
        $projectIds = array_column(self::getUserProject(), 'ProjectID');
        return self::getOwnProjectUserId($projectIds);
    }

    public static function getOwnProjectUserId($projectIds){
        return array_column(
            UserProject::whereIn("ProjectID", $projectIds)
                ->get()->toArray(),
            'UserId'
        );
    }
}
