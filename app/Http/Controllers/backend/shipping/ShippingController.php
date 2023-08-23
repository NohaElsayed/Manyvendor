<?php

namespace App\Http\Controllers\backend\shipping;

use App\Http\Controllers\Controller;
use App\Models\EcomOrderProduct;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Thana;
use App\Models\Logistic;
use App\Models\LogisticArea;
use App\Models\ShippingMethods;
use Alert;

class ShippingController extends Controller
{
    // shipping_zone
    public function shipping_zone()
    {
        $districts = District::all();
        $logistics = Logistic::Active();
        $logistic_areas = LogisticArea::all();
        return view('backend.shipping.shipping_zone.index', compact('districts', 'logistics', 'logistic_areas'));
    }

    // get_division_area
    public function get_division_area(Request $request)
    {
        $thanas = Thana::where('district_id', $request->id)->get();
        $dataSend = "<option value=''>Select area</option>";
        foreach ($thanas as $thana) {
            $dataSend .= "<option value='$thana->id'>$thana->thana_name</option>";
        }
        return $dataSend;
    }


    // shipping_zone_create
    public function shipping_zone_create(Request $request)
    {

        $request->validate([
            'thana_name' => 'required',
        ], [
            'thana_name.required' => translate('Area is required.'),
        ]);

        $thana = new Thana();
        $thana->district_id = $request->division_id;
        $thana->thana_name = $request->thana_name;
        $thana->save();

        Alert::success(translate('Done'), translate('New zone has been added successfully.'));
        return back();

    }

    // shipping_zone_division_create
    public function shipping_zone_division_create(Request $request)
    {
        $thana = new District();
        $thana->district_name = $request->division_name;
        $thana->save();

        Alert::success(translate('Done'), translate('New division has been added successfully.'));
        return back();
    }

    // shipping_zone_division_create
    public function logistic_store(Request $request)
    {
        $thana = new Logistic();
        $thana->name = $request->name;

        if ($request->is_active == 'on') {
            $thana->is_active = true;
        } else {
            $thana->is_active = false;
        }
        $thana->save();

        Alert::success(translate('Done'), translate('New logistic has been added successfully.'));
        return back();
    }

    // logistic_area_store
    public function logistic_area_store(Request $request)
    {
        $logistics_area = new LogisticArea();
        $logistics_area->logistic_id = $request->logistic_id;
        $logistics_area->division_id = $request->division_id;

        $logistics_area->area_id = json_encode($request->area_id);

        $logistics_area->rate = $request->rate;
        $logistics_area->min = $request->min;
        $logistics_area->max = $request->max;
        if ($request->is_active == 'on') {
            $logistics_area->is_active = true;
        } else {
            $logistics_area->is_active = false;
        }
        $logistics_area->save();

        Alert::success(translate('Done'), translate('New area has been added successfully.'));
        return back();
    }


    /*logistic_area_delete*/
    public function logistic_area_delete($id)
    {

        $logistic = LogisticArea::where('id', $id)->first();
        if (vendorActive()) {
            $orders = OrderProduct::where('logistic_id', $logistic->logistic_id)->get();
        } else {
            $orders = EcomOrderProduct::where('logistic_id', $logistic->logistic_id)->get();
        }


        if ($orders->count() > 0) {
            return back()->with('info', translate('Logistic Area Is used in order.'));
        } else {
            $logistic->delete();
            return back()->with('success', translate('Logistic area has been deleted.'));
        }

    }



    /*logistic_area_delete*/
    public function logistic_delete($id)
    {

        $logistic = Logistic::where('id', $id)->first();
        if (vendorActive()) {
            $orders = OrderProduct::where('logistic_id', $id)->get();
        } else {
            $orders = EcomOrderProduct::where('logistic_id', $id)->get();
        }


        if ($orders->count() > 0) {
            return back()->with('info', translate('Logistic  Is used in order.'));
        } else {
            $logistic->delete();
            return back()->with('success', translate('Logistic  has been deleted.'));
        }

    }

    /*logistic_area_edit*/
    public function logistic_area_edit($id)
    {
        $single_area = LogisticArea::where('id', $id)->first();
        $districts = District::all();
        $logistics = Logistic::all();
        $logistic_areas = LogisticArea::all();

        return view('backend.shipping.shipping_zone.edit', compact('districts', 'logistics', 'logistic_areas', 'single_area'));
    }


    // logistic_area_store
    public function logistic_area_update(Request $request, $id)
    {
        $logistic_area_update = LogisticArea::findOrFail($id);
        $logistic_area_update->logistic_id = $request->logistic_id;
        $logistic_area_update->area_id = 'ok';
        $logistic_area_update->save();
        $logistic_area_update->division_id = $request->division_id;
        $logistic_area_update->rate = $request->rate;
        $logistic_area_update->min = $request->min;
        $logistic_area_update->max = $request->max;
        if ($request->is_active == 'on') {
            $logistic_area_update->is_active = true;
        } else {
            $logistic_area_update->is_active = false;
        }

        $area_array = array();
        foreach ($request->area_id as $area) {
            array_push($area_array, $area);
        }
        $logistic_area_update->area_id = $area_array;

        // $data = explode(',', $request->area_id);
        //     $pro_value = array();
        //     foreach ($data as $item) {
        //         array_push($pro_value, $item);
        //     }

        //     $logistic_areas = json_encode($pro_value);
        //     $logistic_area_update->area_id = $logistic_areas;


        $logistic_area_update->save();

        Alert::success(translate('Done'), translate('Division has been updated successfully'));
        return back();
    }

    public function logistic_area_activation(Request $request)
    {
        $logistic_area_activation = LogisticArea::where('id', $request->id)->first();
        if ($logistic_area_activation->is_active == 0) {
            $logistic_area_activation->is_active = 1;
            $logistic_area_activation->save();
        } else {
            $logistic_area_activation->is_active = 0;
            $logistic_area_activation->save();
        }
        return response(['message' => translate('Status has been changed')], 200);
    }

    // logistics
    public function logistics()
    {
        $logistics = Logistic::latest()->get();
        return view('backend.shipping.logistics.index', compact('logistics'));
    }

    // logistic_activation
    public function logistic_activation(Request $request)
    {
        // Logistic
        $logistic_activation = Logistic::where('id', $request->id)->first();

        if ($logistic_activation->is_active == 0) {
            $logistic_activation->is_active = 1;
            $logistic_activation->save();
        } else {
            $logistic_activation->is_active = 0;
            $logistic_activation->save();
        }

        // LogisticArea
        $logistic_zone_activation = LogisticArea::where('logistic_id', $request->id)->get();

        foreach ($logistic_zone_activation as $activation) {
            if ($activation->is_active == 1) {
                $activation->is_active = 0;
                $activation->save();
            } else {
                $activation->is_active = 1;
                $activation->save();
            }
        }
        return response(['message' => 'Status has been changed'], 200);
    }


}
