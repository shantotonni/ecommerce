<?php

namespace App\Http\Controllers;

use App\Model\Banner;
use App\Model\Dealer;
use App\Model\District;
use App\Model\Upazilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DealerController extends Controller
{
    //
    public function  __construct()
    {
        $this->middleware('auth');
    }


    public function index($id = null)
    {
        $data = [];
        $data['featureName'] = "Dealer";
        $data['actionTitle'] = "Add";
        $data['action'] = 'dealer';

        if ($id != null) {
            $dealer = Dealer::where('DealerId', $id)
                ->first();
            $upazilas = Upazilla::where('DistrictCode', $dealer->DistrictCode)->get();
            $data['selectedDealer'] = $dealer;
            $data['upazilas'] = $upazilas;

            $data['actionTitle'] = "Update";
        }

        $data['dealers'] = Dealer::orderBy('DealerId', 'DESC')->get();
        $data['districts'] = District::all();
        return view('setup/dealer_manage', $data);
    }

    public function createOrUpdate(Request $request){

        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Phone' => 'required|string|max:20',
            'DistrictCode' => 'required|integer',
            'UpazillaCode' => 'required|integer',
            'Address' => 'nullable|string',
            'Latitude' => 'required|string',
            'Longitude' => 'required|string',
            'ProductGroup' => 'required|string',
        ]);
        $id = $request->input('id');
        if (!empty($id)) {
            $dealer = Dealer::find($id);
            if ($dealer) {
                $dealer->update($validated);
                Toastr()->success('Dealer Updated Successfully');
            } else {
                Toastr()->error('Dealer not found');
            }
        } else {
            if (Dealer::create($validated)) {
                Toastr()->success('Dealer Created Successfully');
            } else {
                Toastr()->error('Error creating dealer');
            }
        }

        return redirect()->back();
    }

    public function delete($id)
    {
        $dealer = Dealer::findOrFail($id);

        if ($dealer->delete()) {
            Toastr()->success('Dealer Delete Successfully');
        } else {
            Toastr()->error('Error on delete');
        }
        return redirect()->back();
    }
}
