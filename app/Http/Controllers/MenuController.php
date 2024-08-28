<?php

namespace App\Http\Controllers;

use App\Model\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $menus = Menu::orderBy('MenuId','desc')->get();
        return view('menu.index',compact('menus'));
    }

    public function create(){
        return view('menu.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'MenuName'=>'required',
            'SubMenuName'=>'required',
            'Link'=>'required',
            'Active'=>'required',
        ]);

        $menu = new Menu();
        $menu->MenuName     = $request->MenuName;
        $menu->SubMenuName  = $request->SubMenuName;
        $menu->Link         = $request->Link;
        $menu->MenuOrder    = $request->MenuOrder;
        $menu->Active       = $request->Active;
        $menu->save();

        Toastr()->success('Menu Added Successfully');
        return redirect()->route('menu-list.index');
    }

    public function edit($id){
        $menu = Menu::find($id);
        return view('menu.edit',compact('menu'));
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'MenuName'=>'required',
            'SubMenuName'=>'required',
            'Link'=>'required',
            'Active'=>'required',
        ]);

        $menu = Menu::find($id);
        $menu->MenuName     = $request->MenuName;
        $menu->SubMenuName  = $request->SubMenuName;
        $menu->Link         = $request->Link;
        $menu->MenuOrder    = $request->MenuOrder;
        $menu->Active       = $request->Active;
        $menu->save();

        Toastr()->success('Menu updated Successfully');
        return redirect()->route('menu-list.index');
    }

    public function destroy($id){
        //
    }
}
