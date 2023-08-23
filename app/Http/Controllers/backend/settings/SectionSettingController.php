<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\SectionSettings;
use App\Models\Settings;
use Illuminate\Http\Request;

class SectionSettingController extends Controller
{
    /*all section */
    public function index()
    {
        $sections = SectionSettings::orderBy('sort', 'asc')->get();
        return view('backend.settings.index', compact('sections'));
    }

    /*sorting section*/
    public function sectionSort(Request $request)
    {
        if (env('APP_ENV') == 'production') {
            $i = 1;
            $s = json_encode($request->order);
            foreach (json_decode($s) as $section) {
                $c = SectionSettings::findOrFail((int)$section->id);
                $c->sort = (int)$section->sort;
                $c->save();
                $i++;
            }
        }
        return response(['message' => translate('Section ordering has been changed.')], 200);
    }

    /*section status change*/
    public function sectionStatus(Request $request)
    {
        if (env('APP_ENV') == 'production') {
            $section = SectionSettings::find($request->id);
            if ($section->active == 1) {
                $section->active = 0;
                $section->save();
            } else {
                $section->active = 1;
                $section->save();
            }
        }
        return response(['message' => translate('Section\'s active status has been changed.')], 200);
    }


    /*business settings*/
    public function businessSettings()
    {
        return view('backend.settings.business');
    }

    /*business setting save*/
    public function businessSettingsStore(Request $request)
    {


        if ($request->has('seller')) {
            $system = Settings::where('name', $request->seller)->first();
            $system->value = $request->seller_status;
            $system->save();
        }
        if ($request->has('primary_color')) {
            $system = Settings::where('name', $request->primary_color)->first();
            $system->value = $request->p_color;
            $system->save();
        }
        if ($request->has('secondary_color')) {
            $system = Settings::where('name', $request->secondary_color)->first();
            $system->value = $request->s_color;
            $system->save();
        }
        if ($request->has('seller_mode')) {
            $system = Settings::where('name', $request->seller_mode)->first();
            $system->value = $request->mode_status;
            $system->save();
        }
//        return $request;
        if ($request->has('verification')) {
            $system = Settings::where('name', $request->verification)->first();
            $system->value = $request->verification_status;
            $system->save();
        }
        if ($request->has('login_modal')) {
            $system = Settings::where('name', $request->login_modal)->first();
            $system->value = $request->login_status;
            $system->save();
        }

        if ($request->has('checkout')) {
            overWriteEnvFile('GUEST_CHECKOUT', $request->guest_status);
        }

        if ($request->has('logistic_active')) {
            overWriteEnvFile('LOGISTIC_ACTIVE', $request->logistic_active);
        }


        if ($request->has('deliver_active')) {
            overWriteEnvFile('DELIVER_ACTIVE', $request->deliver_active);
        }

        if ($request->has('deliver_process')) {
            overWriteEnvFile('DELIVER_PROCESS', $request->deliver_process);
        }

        if ($request->has('TIME_ZONE')) {
            overWriteEnvFile('TIME_ZONE', $request->TIME_ZONE);
        }


        return back()->with('success', translate('System settings has been updated.'));
    }

    // TODO::PORE kora lagbey

    /*additional*/
    public function additionalSettings()
    {
        return view('backend.settings.additional');
    }

    /*additional setting save*/
    public function additionalSettingsStore(Request $request)
    {

        if ($request->has('shipping_boundary')) {
            $system = Settings::where('type_shipping', $request->shipping_boundary)->first();
            $system->value = $request->shipping_boundary;
            $system->save();
        }

        if ($request->has('return')) {
            $system = Settings::where('type_return', $request->return)->first();
            $system->value = $request->return;
            $system->save();
        }

        if ($request->has('payment_system')) {
            $system = Settings::where('type_payment_system', $request->payment_system)->first();
            $system->value = $request->payment_system;
            $system->save();
        }

        return back()->with('success', translate('Additional settings has been changed.'));
    }

}
