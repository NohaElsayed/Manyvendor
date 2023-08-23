<?php

namespace App\Http\Controllers;

use App\DeliverAssign;
use App\DeliverUser;
use App\DeliveymenTrack;
use App\EcomDeliverAssign;
use App\EcomDeliveymenTrack;
use App\Mail\NewDeliverConfirm;
use App\Models\EcomOrderProduct;
use App\Models\OrderProduct;
use App\Models\UserHasGroup;
use App\Notifications\OrderAssign;
use App\Notifications\OrderLocation;
use App\Notifications\OrderPick;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class DeliverUserEcommerceController extends Controller
{
    public function register()
    {
        return view('frontend.homepage.register');
    }

    public function registerStore(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'permanent_address' => 'required',
            'present_address' => 'required',
            'phone_num' => 'required',
            'document' => 'required',
            'pic' => 'required',
        ],
            [
                'first_name.required' => 'FirstName is Required',
                'last_name.required'=>'Last Name is Required',
                'email.required'=>'Email is Required',
                'gender.required'=>'Gender is required',
                'permanent_address.required'=>'Permanent Address is Required',
                'present_address.required'=>'Present Address is required',
                'phone_num.required'=>'Phone Number is required',
                'document.required'=>'Document is required',
                'pic.required'=>'Profile Picture is required'
            ]
        );
        $user = new DeliverUser();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->permanent_address = $request->permanent_address;
        $user->present_address = $request->present_address;
        $user->phone_num = $request->phone_num;
        if ($request->hasFile('document')) {
            $user->document = fileUpload($request->document, 'deliver');
        }
        if ($request->hasFile('pic')) {
            $user->pic = fileUpload($request->pic, 'deliver');
        }
        $user->save();
        return back()->with(['status' => 'Waiting for confirmation']);
    }

    public function deliverUserIndex()
    {
        $users = DeliverUser::where('confirm', false)->latest()->paginate(10);
        return view('backend.deliver.requestList', compact('users'));
    }

    public function deliverUserDetails($id)
    {
        $user = DeliverUser::where('confirm', false)->findOrFail($id);
        return view('backend.deliver.details', compact('user'));
    }

    public function deliverUserConfirm(Request $request)
    {
        $password = Str::random(6);
        if ($request->status == 'Confirm') {
            $deliver =  DeliverUser::where('id', $request->id)->first();

            $user = new User();
            $user->name = $deliver->first_name.'-'.$deliver->last_name;
            //slug save
            $user->slug = $user->name;
            $user->genders = $deliver->genders;
            $user->tel_number = $deliver->phone_num;
            $user->email = $deliver->email;
            $user->password = Hash::make($password);
            $user->avatar = $deliver->pic;
            $user->user_type = 'Deliver';
            $user->save();
            $user->assignGroup(5);

            /*deliver */
            $deliver->confirm = true;
            $deliver->confirm_by = Auth::id();
            $deliver->confirm_at = Carbon::now();
            $deliver->user_id = $user->id;
            $deliver->save();
            try {
                Mail::to($deliver->email)->send(new NewDeliverConfirm($password));
            }catch (\Exception $exception){}

            Alert::toast('Request is Confirm', 'success')
                ->autoClose(1000)
                ->position('top-end');
        } else {
            $user =  DeliverUser::where('id', $request->id)->first();
            fileDelete($user->pic);
            fileDelete($user->document);
            $user->delete();
            Alert::toast('Request is cancel', 'success')
                ->autoClose(1000)
                ->position('top-end');
        }
        return back();
    }

    public function deliverUserAbout($id){
        $user = DeliverUser::where('confirm', true)->where('user_id',$id)->first();
        return view('backend.deliver.about', compact('user'));
    }


    public function index(Request $request)
    {
        $deliverArray = array();
        $deliver = UserHasGroup::where('group_id', 5)->get();
        foreach ($deliver as $d) {
            array_push($deliverArray, $d->user_id);
        }

        if ($request->search != null) {
            $users = User::where('email', 'LIKE', '%' . $request->search . '%')->whereIn('id', $deliverArray)->latest()->paginate(10);
        } else {
            $users = User::whereIn('id', $deliverArray)->latest()->paginate(10);
        }

        return view('backend.deliver.list', compact('users'));
    }


    public function banned($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->banned == true) {
            $user->banned = false;
        } else {
            $user->banned = true;
        }
        $user->save();
        return back()->with('success', translate('This user has been banned.'));;
    }


    /*todo::start delivery order*/

    public function ordersList(Request $request)
    {


        $orders = null;
        $condition = array();

        if ($request->search) {
            if (!is_null($request->email)) {
                $condition = array_merge($condition, ['email' => $request->email]);
            }
            if (!is_null($request->booking_code)) {
                $condition = array_merge($condition, ['booking_code' => $request->booking_code]);
            }
            if (!is_null($request->order_number)) {
                $condition = array_merge($condition, ['order_number' => $request->order_number]);
            }

            if (!is_null($request->phone)) {
                $condition = array_merge($condition, ['phone' => $request->phone]);
            }


            if (!is_null($request->end_date)) {
                $start = null;
                $end = Carbon::parse($request->end_date)
                    ->endOfDay()
                    ->toDateTimeString();
                if ($request->has('start_date')) {
                    $start = Carbon::parse($request->start_date)
                        ->startOfDay()
                        ->toDateTimeString();
                } else {
                    $start = Carbon::yesterday()->startOfDay()->toDateTimeString();
                }

                if (empty($condition)) {
                    $orders = EcomOrderProduct::with('orderAssignToDeliver')->where('status', 'confirmed')->whereBetween('created_at', [$start, $end])->paginate(10);
                } else {
                    $orders = EcomOrderProduct::with('orderAssignToDeliver')->where('status', 'confirmed')->where($condition)->whereBetween('created_at', [$start, $end])->latest()->paginate(10);

                }

            } else {
                $orders = EcomOrderProduct::with('orderAssignToDeliver')->where('status', 'confirmed')->where($condition)->latest()->paginate(10);
            }
        } else {
            $orders = EcomOrderProduct::with('orderAssignToDeliver')->where('status', 'confirmed')->latest()->paginate(10);
        }

        return view('backend.deliver.orderIndex', compact('orders'));
    }


    public function assignCreate($id)
    {

        $deliverArray = array();
        $deliver = UserHasGroup::where('group_id', 5)->get();
        foreach ($deliver as $d) {
            array_push($deliverArray, $d->user_id);
        }

        $users = User::whereIn('id', $deliverArray)->where('banned', 0)->get();
        return view('backend.deliver.assign', compact('users', 'id'));
    }


    public function assignStore(Request $request)
    {
        if (!$request->has('deliver_user_id')) {
            Alert::toast('Select the user', 'warning')
                ->autoClose(1000)
                ->position('top-end');
            return back();
        }else{
            $user = User::where('id', $request->deliver_user_id)->first();
            $assignUser = EcomDeliverAssign::where('deliver_user_id', $request->deliver_user_id)
                ->where('order_id', $request->order_id)->first();

            if ($assignUser == null) {
                $assign = new EcomDeliverAssign();
                $assign->deliver_user_id = $request->deliver_user_id;
                $assign->order_id = $request->order_id;
                $assign->user_id = Auth::id();
                $assign->save();

                Alert::toast('Order assign to ' . $user->name, 'success')
                    ->autoClose(2000)
                    ->position('top-end');

                /*assign order*/

                try {
                    if ($user != null){
                        Notification::send($user, new OrderAssign());
                    }
                } catch (\Exception $exception) {}
                return back();
            } else {
                Alert::toast('Order Already assign to' . $user->name, 'success')
                    ->autoClose(2000)
                    ->position('top-end');
                return back();
            }
        }


    }


    public function assignDetails($id)
    {
        $deliver = EcomDeliverAssign::with('deliverUser')
            ->with('orderDetails')
            ->with('deliverSummery')
            ->with('assignUser')
            ->findOrFail($id);

        return view('backend.deliver.assignDetails', compact('deliver'));
    }


    public function deliverPick($id){
        $deliver = EcomDeliverAssign::findOrFail($id);
        return view('backend.deliver.durationToDeliver',compact('deliver'));
    }

    public function deliverPickStore(Request $request){
        $deliver = EcomDeliverAssign::findOrFail($request->id);
        $deliver->pick = true;
        $deliver->duration = $request->duration;
        $deliver->pick_date = Carbon::now();
        $deliver->save();
        $user = User::where('id',$deliver->user_id)->first();
        try {
            if ($user != null){
                Notification::send($user, new OrderPick());
            }
        } catch (\Exception $exception) {}

        Alert::toast('Order Is picked', 'success')
            ->autoClose(2000)
            ->position('top-end');
        return back();
    }


    /*location update*/
    public function locationStatus($id){
        $deliver = EcomDeliverAssign::findOrFail($id);
        return view('backend.deliver.location',compact('deliver'));
    }

    public function locationStatusStore(Request $request){
        $delivermen = new EcomDeliveymenTrack();
        $delivermen->location = $request->location;
        $delivermen->deliverymen_id = Auth::id();
        $delivermen->deliver_assign_id = $request->deliver_assign_id;
        $delivermen->order_id = $request->order_id;
        $delivermen->save();
        $deliver = EcomDeliverAssign::where('id',$request->deliver_assign_id)->first();
        $user = User::where('id',$deliver->user_id)->first();

        try {
            if ($user != null){
                Notification::send($user, new OrderLocation());
            }
        } catch (\Exception $exception) {}

        Alert::toast('Location is updated', 'success')
            ->autoClose(2000)
            ->position('top-end');
        return back();
    }

    //there are the deliver dashboard
    public function deliverDashboard()
    {
        $assignOrder = EcomDeliverAssign::with('deliverUser')
            ->with('orderDetails')
            ->with('assignUser')
            ->where('deliver_user_id', Auth::id())
            ->where('delivered', false)->latest()->get();
        return view('backend.deliver.dashboard', compact('assignOrder'));
    }


    public function orderDelivered()
    {
        $deliverOrder = EcomDeliverAssign::with('deliverUser')
            ->with('orderDetails')
            ->with('assignUser')
            ->where('deliver_user_id', Auth::id())
            ->where('delivered', true)->get();
        return view('backend.deliver.deliverdorder', compact('deliverOrder'));
    }

    public function deliverPickRemove($id){
        $assign = EcomDeliverAssign::where('id',$id)->first();
        $location = EcomDeliveymenTrack::where('deliver_assign_id',$id)->get();
        foreach ($location as $l){
            $l->delete();
        }
        $assign->delete();
        Alert::toast('Delivery assign Details is delete', 'success')
            ->autoClose(1000)
            ->position('top-end');
        return back();
    }
}
