<?php

namespace App\Http\Controllers;

use App\Model\Business;
use App\Model\Menu;
use App\Model\Project;
use App\Model\UserBusiness;
use App\Model\UserManager;
use App\Model\UserMenu;
use App\Model\UserProject;
use App\Model\UserUpazilla;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class UserManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list()
    {
        $user_project = CommonHelper::getUserProject();
        $userId = UserProject::where('ProjectId',$user_project[0]['ProjectID'])->pluck('UserId');
        $users = User::filter()->whereIn('UserId', $userId)->get();

        return view('user.list', compact('users'));
    }

    public function create(){
        $businesses = CommonHelper::getUserBusiness();
        $districts = DB::select(DB::raw('SELECT * FROM vDistrict'));
        $projects = CommonHelper::getUserProject();
        return view('user.create',compact('businesses','projects','districts'));
    }

    public function store(Request $request)
    {
        try {

            $user = new User();
            $user->Name        = $request->name;
            $user->StaffId     = $request->staffId;
            $user->Designation = $request->designation;
            $user->UserName    = $request->userName;
            $user->DistrictCode= $request->District;
            $user->Active      = $request->Active ? 'Y' : 'N';
            $user->Password    = bcrypt($request->password);

            DB::beginTransaction();

            $user->save();
            // Add User Business
            if ($this->addUserProject($request, $user->UserId) && $this->addUserBusiness($request, $user->UserId)) {
                foreach ($request->Thana as $thana) {
                    $user_upazilla               = new UserUpazilla();
                    $user_upazilla->UserId       = $user->UserId;
                    $user_upazilla->ThanaCode    = $thana;
                    $user_upazilla->DistrictCode = $request->District;
                    $user_upazilla->save();
                }

                DB::commit();
                Toastr()->success('Successfully Added');
            } else {
                DB::rollBack();
                Toastr()->error('Something Went Wrong');
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            Toastr()->error('Something Went Wrong');
        }
        return redirect()->back();
    }

    public function edit($userid){
        $districts = DB::select(DB::raw('SELECT * FROM vDistrict'));
        $user = UserManager::where('UserId',$userid)->with('thana')->first();

        $thanas = DB::select(DB::raw("SELECT * FROM vUpazilla where DistrictCode='$user->DistrictCode'"));
        $user_thana = UserUpazilla::where('UserId',$userid)->where('DistrictCode', $user->DistrictCode)->pluck('ThanaCode')->toArray();

        return view('user.edit',compact('user','districts','thanas','user_thana'));
    }

    public function update(Request $request, $id){
        try {
            $user = UserManager::where('UserId',$id)->first();
            $user->Name        = $request->name;
            $user->StaffId     = $request->staffId;
            $user->Designation = $request->designation;
            $user->UserName    = $request->userName;
            $user->DistrictCode    = $request->District;
            $user->Active      = $request->Active ? 'Y' : 'N';
            $user->save();

            DB::beginTransaction();

            UserUpazilla::where('UserId',$id)->delete();

           foreach ($request->Thana as $thana) {
               $user_upazilla               = new UserUpazilla();
               $user_upazilla->UserId       = $user->UserId;
               $user_upazilla->ThanaCode    = $thana;
               $user_upazilla->DistrictCode = $request->District;
               $user_upazilla->save();
           }

           DB::commit();
           Toastr()->success('Successfully Added');
           return redirect()->back();

        }catch (\Exception $ex){
            Log::error($ex->getMessage());
            Toastr()->error('Something Went Wrong');
        }
    }

    public function delete($id){
        UserManager::where('UserId',$id)->first();
        Toastr()->warning('Under Construction');
        return redirect()->back();
    }

    private function addUserBusiness(Request $request, $userId)
    {
        try {
            $userBusinessData = [];

            $userBusinessData[] = [
                'ProjectID' => $request->projectId,
                'UserId' => $userId,
                'Business' => $request->business,
            ];

            return UserBusiness::insert($userBusinessData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return false;
        }
    }

    private function addUserProject(Request $request, $userId)
    {
        try {
            $userProjectData = [];
            $userProjectData[] = [
                'ProjectID' => $request->projectId,
                'UserId' => $userId,
            ];
            return UserProject::insert($userProjectData);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function userMenuPermission($id){
        $user_menu = UserMenu::where('UserId',$id)->pluck('MenuId')->toArray();
        $all_menu = Menu::orderBy('MenuId','desc')->get();
        //dd($all_menu);
        return view('user.manage_menu_permission',compact('user_menu','all_menu','id'));
    }

    public function userMenuPermissionStore(Request $request){
        $userId = $request->UserId;
        $permission = $request->MenuId;

        $sortedPerm = [];
        foreach ($permission as $key => $value) {
            if ($value ) array_push($sortedPerm, $value);
        }
        $current = UserMenu::where('UserId', $userId)->pluck('MenuId')->toArray();
        $inserted = array_diff($sortedPerm, $current);

        foreach ($inserted as $item) {
            UserMenu::create(['UserId' => $userId, 'MenuId' => $item]);
        }

        $remove = array_diff($current, $sortedPerm);
        UserMenu::where('UserId', $userId)->whereIn('MenuId', $remove)->delete();

        Toastr()->success('Successfully Added');
        return redirect()->back();
    }

    public function manageMenuPermission(Request $request, $userId = null)
    {
        try {
            // store User Menu permission
            if (strtolower($request->method()) == 'post') {
                $userId = $request->input('userId');
                // Check Permission for user
                if (!CommonHelper::hasAccessOnTheUser($userId)) {
                    Toastr()->error("You don't have permission to do this");
                    return redirect()->back();
                }

                DB::beginTransaction();
                if ($this->addMenuPermission($request, $userId)) {
                    DB::commit();
                    Toastr()->success('Permission Added Successfully');
                } else {
                    DB::rollBack();
                    Toastr()->error('Failed  to add Permission');
                }
                return redirect()->back();
            }

            // Check Permission for user

            if (!CommonHelper::hasAccessOnTheUser($userId)) {
                // dd("bad");
                Toastr()->error("You are not permitted to do this");
                return redirect('user-list');
            }
            $permittedUserIds = CommonHelper::getPermittedUserId();
            $data['users'] = User::whereIn('UserId', $permittedUserIds)->get();
            $data['selectedUser'] = User::where('UserId', $userId)->first();
            $data['menus'] = Menu::with(
                [
                    'userMenu' => function ($query) use ($userId) {
                        $query->where('UserId', $userId);
                    }
                ]
            )->get()->groupBy('MenuName');
            //        dd($data['menus']->toArray());
            return view('user/manage_menu_permission', $data);
        } catch (\Exception $ex) {
            Toastr()->error('Something Went Wrong');
            return redirect()->back();
        }
    }

    private function addMenuPermission(Request $request, $userId)
    {
        try {
            UserMenu::where('UserId', $userId)->delete();
            $data = [];
            foreach ($request->userMenu as $menuItem) {
                $data[] = [
                    'UserId' => $userId,
                    'MenuId' => $menuItem,
                ];
            }
            return UserMenu::insert($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function districtWiseThana(Request $request){
        $district = explode('-',$request->district);
        $thanas = DB::select(DB::raw("SELECT * FROM vUpazilla where DistrictCode='$district[0]'"));
        $string = "<option value='' disabled selected>Select Item</>";
        foreach($thanas as $value){
            $string .= "<option value='" . $value->UpazillaCode . "'>" . ucfirst($value->UpazillaName) . "</option>";
        }
        return response()->json($string);
    }
}
