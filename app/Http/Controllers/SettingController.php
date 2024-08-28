<?php

namespace App\Http\Controllers;

use App\Model\Search;
use App\Model\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use UploadAble;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {

        if ($request->has('site_logo') && ($request->file('site_logo') instanceof UploadedFile)) {

            if (config('settings.site_logo') != null) {
                $this->deleteOne(config('settings.site_logo'));
            }
            $logo = $this->uploadOne($request->file('site_logo'), 'img');
            Setting::set('site_logo', $logo);

        } elseif ($request->has('site_favicon') && ($request->file('site_favicon') instanceof UploadedFile)) {

            if (config('settings.site_favicon') != null) {
                $this->deleteOne(config('settings.site_favicon'));
            }
            $favicon = $this->uploadOne($request->file('site_favicon'), 'img');
            Setting::set('site_favicon', $favicon);

        } else {

            $keys = $request->except('_token');

            foreach ($keys as $key => $value)
            {
                Setting::set($key, $value);
            }
        }
        return redirect()->back()->with('Settings updated successfully');

    }

    public function searches(){
        $searches = Search::orderBy('created_at','desc')->paginate(20);
        return view('search.search',compact('searches'));
    }
}
