<?php

namespace App\Http\Controllers\ecommerce;

use App\DeliverAssign;
use App\DeliveymenTrack;
use App\EcomDeliverAssign;
use App\EcomDeliveymenTrack;
use App\EcomProductVariantStock;
use App\Http\Controllers\Controller;
use App\Models\EcomOrderProduct;
use App\Notifications\OrderNotification;
use App\User;
use Illuminate\Http\Request;
use Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Alert;

class AdminOrderController extends Controller
{

    /**
     * TOTAL ORDER
     */

    public function index(Request $request)
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
                    $orders = EcomOrderProduct::latest()->with('product_stock')->whereBetween('created_at', [$start, $end])->get();
                } else {
                    $orders = EcomOrderProduct::latest()->with('product_stock')->where($condition)->whereBetween('created_at', [$start, $end])->get();

                }

            } else {
                $orders = EcomOrderProduct::latest()->with('product_stock')->where($condition)->get();
            }
        } else {
            $orders = EcomOrderProduct::latest()->with('product_stock')->paginate(50);
        }
        return view('backend.ecommerce.order_index', compact('orders'));
    }

    /**
     * CONFIRM
     */

    public function confirm($id)
    {
        $confirm = EcomOrderProduct::findOrFail($id);
        if ($confirm->status != 'confirmed') {
            $confirm->status = 'confirmed';
            $confirm->comment = 'New Order Confirmed';
            $confirm->commentedBy = Auth::user()->id;
            $confirm->save();




            $user = User::first();

            $details = [
                'greeting' => 'Mr/Mrs.' . ' ' . $user->name,
                'body' => translate('Your order has been confirmed.'),
                'thanks' => translate('Thank you for shopping with us.'),
                'actionText' => translate('View Order'),
                'actionURL' => route('customer.orders'),
            ];
            try {
                Notification::send($user, new OrderNotification($details));
            }catch (\Exception $exception){}
        }


        Alert::toast('Order Confirmed', 'success')
            ->autoClose(1000)
            ->position('top-end');
        return back();
    }

    /**
     * CANCEL
     */

    public function cancel($id)
    {

        $cancel = EcomOrderProduct::findOrFail($id);

        $cancel->status = 'canceled';
        $cancel->comment = 'Order Canceled';
        $cancel->commentedBy = Auth::user()->id;
        $cancel->save();


        Alert::toast('Order Canceled', 'success')
            ->autoClose(1000)
            ->position('top-end');

        $user = User::first();

        $details = [
            'greeting' => 'Mr/Mrs.' . ' ' . $user->name,
            'body' => translate('Your order has been canceled.'),
            'thanks' => translate('Thank you for shopping with us.'),
            'actionText' => translate('Shop Again'),
            'actionURL' => route('customer.orders'),
        ];
        try {
            Notification::send($user, new OrderNotification($details));
        }catch (\Exception $exception){}


        return back();
    }

    /**
     * processing
     */

    public function processing($id)
    {
        $cancel = EcomOrderProduct::findOrFail($id);
        $cancel->status = 'processing';
        $cancel->comment = 'Order Processing';
        $cancel->commentedBy = Auth::user()->id;
        $cancel->save();

        Alert::toast('Order Processing', 'success')
            ->autoClose(1000)
            ->position('top-end');

        $user = User::first();

        $details = [
            'greeting' => 'Mr/Mrs.' . ' ' . $user->name,
            'body' => translate('Your order is Processing.'),
            'thanks' => translate('Thank you for shopping with us.'),
            'actionText' => translate('Shop Again'),
            'actionURL' => route('customer.orders'),
        ];
        try {
            Notification::send($user, new OrderNotification($details));
        }catch (\Exception $exception){}

        return back();
    }

    /**
     * quality_check
     */

    public function quality_check($id)
    {
        $cancel = EcomOrderProduct::findOrFail($id);
        $cancel->status = 'quality_check';
        $cancel->comment = 'Quality Check';
        $cancel->commentedBy = Auth::user()->id;
        $cancel->save();

        Alert::toast('Order Quality Checking', 'success')
            ->autoClose(1000)
            ->position('top-end');

        $user = User::first();

        $details = [
            'greeting' => 'Mr/Mrs.' . ' ' . $user->name,
            'body' => translate('Your order is in Quality Check Process.'),
            'thanks' => translate('Thank you for shopping with us.'),
            'actionText' => translate('Shop Again'),
            'actionURL' => route('customer.orders'),
        ];
        try {
            Notification::send($user, new OrderNotification($details));
        }catch (\Exception $exception){}
        return back();
    }

    /**
     * product_dispatched
     */

    public function product_dispatched($id)
    {
        $cancel = EcomOrderProduct::findOrFail($id);
        $cancel->status = 'product_dispatched';
        $cancel->comment = 'Product Dispatched';
        $cancel->commentedBy = Auth::user()->id;
        $cancel->save();

        Alert::toast('Product Dispatched', 'success')
            ->autoClose(1000)
            ->position('top-end');

        $user = User::first();

        $details = [
            'greeting' => 'Mr/Mrs.' . ' ' . $user->name,
            'body' => translate('Your order is Dispatched.'),
            'thanks' => translate('Thank you for shopping with us.'),
            'actionText' => translate('Shop Again'),
            'actionURL' => route('customer.orders'),
        ];
        try {
            Notification::send($user, new OrderNotification($details));
        }catch (\Exception $exception){}

        return back();
    }

    /**
     * delivered
     */

    public function delivered($id)
    {
        if (deliverActive()){
             $assign = EcomDeliverAssign::where('order_id',$id)->where('deliver_user_id',Auth::id())->first();
             if ($assign !=null){
                 $assign->delivered = true;
                 $assign->save();
                 $cancel = EcomOrderProduct::findOrFail($id);
                 if ($cancel->status != 'cancel' || $cancel->status != 'follow_up' || $cancel->status == "delivered") {
                     $cancel->status = 'delivered';
                     $cancel->comment = 'Product Delivered';
                     $cancel->commentedBy = Auth::user()->id;
                     $cancel->save();
                     $stock = EcomProductVariantStock::where('id', $cancel->product_stock_id)->first();
                     $stock->quantity -= $cancel->quantity;
                     $stock->save();


                 }
                 $cancel->status = 'delivered';
                 $cancel->comment = 'Product Delivered';
                 $cancel->commentedBy = Auth::user()->id;
                 $cancel->save();

                 Alert::toast('Product Delivered', 'success')
                     ->autoClose(1000)
                     ->position('top-end');

                 $user = User::first();

                 $details = [
                     'greeting' => 'Mr/Mrs.' . ' ' . $user->name,
                     'body' => translate('Your order is Delivered.'),
                     'thanks' => translate('Thank you for shopping with us.'),
                     'actionText' => translate('Shop Again'),
                     'actionURL' => route('customer.orders'),
                 ];
                 try {
                     Notification::send($user, new OrderNotification($details));
                 } catch (\Exception $exception) {
                 }


                 return back();
             }else{
                 Alert::toast('This order not assign to you', 'success')
                     ->autoClose(1000)
                     ->position('top-end');
                 return back();
             }


        }else{
            $cancel = EcomOrderProduct::findOrFail($id);
            if ($cancel->status != 'cancel' || $cancel->status != 'follow_up' || $cancel->status == "delivered") {
                $cancel->status = 'delivered';
                $cancel->comment = 'Product Delivered';
                $cancel->commentedBy = Auth::user()->id;
                $cancel->save();
                $stock = EcomProductVariantStock::where('id', $cancel->product_stock_id)->first();
                $stock->quantity -= $cancel->quantity;
                $stock->save();


            }
            $cancel->status = 'delivered';
            $cancel->comment = 'Product Delivered';
            $cancel->commentedBy = Auth::user()->id;
            $cancel->save();

            Alert::toast('Product Delivered', 'success')
                ->autoClose(1000)
                ->position('top-end');

            $user = User::first();

            $details = [
                'greeting' => 'Mr/Mrs.' . ' ' . $user->name,
                'body' => translate('Your order is Delivered.'),
                'thanks' => translate('Thank you for shopping with us.'),
                'actionText' => translate('Shop Again'),
                'actionURL' => route('customer.orders'),
            ];
            try {
                Notification::send($user, new OrderNotification($details));
            } catch (\Exception $exception) {
            }


            return back();
        }

    }


    /**
     * FOLLOW UP
     */

    public function followup($id)
    {
        $followup = EcomOrderProduct::where('id', $id)->first();
        return view('backend.ecommerce.followup_modal', compact('followup'));
    }

    /**
     * FOLLOW UP COMMENT
     */

    public function followup_comment(Request $request, $id)
    {
        $followup_comment = EcomOrderProduct::findOrFail($id);
        $followup_comment->status = 'follow_up';
        $followup_comment->comment = $request->comment;
        $followup_comment->commentedBy = Auth::user()->id;
        $followup_comment->save();

        /*delete the assign data*/
        $deliver = EcomDeliverAssign::where('order_id',$id)->first();
        if($deliver != null){
            $deliver->delete();
        }

        $deliverTrack = EcomDeliveymenTrack::where('order_id',$id)->first();
        if($deliverTrack != null){
            $deliverTrack->delete();
        }
        Alert::toast('order On Follow Up', 'success')
            ->autoClose(1000)
            ->position('top-end');

        $user = User::first();

        $details = [
            'greeting' => 'Mr/Mrs.' . ' ' . $user->name,
            'body' => translate('Your order is On hold. Please contact with us for your order confirmation.'),
            'thanks' => translate('Thank you for shopping with us.'),
            'actionText' => translate('View Order'),
            'actionURL' => route('customer.orders'),
        ];

        try {
            Notification::send($user, new OrderNotification($details));
        } catch (\Exception $exception) {
        }


        return back();
    }

    /**
     * FIND ORDER
     */

    public function find_order(Request $request)
    {
        $getDatas = null;
        $condition = array();
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
                $getDatas = EcomOrderProduct::whereBetween('created_at', [$start, $end])->get();
            } else {
                $getDatas = EcomOrderProduct::where($condition)->whereBetween('created_at', [$start, $end])->get();
            }

        } else {
            $getDatas = EcomOrderProduct::where($condition)->get();
        }

        return view('backend.ecommerce.search_result', compact('getDatas'));

    }

    /**
     * FILTER ORDER
     */

    public function filter($type)
    {
        $getOrders = EcomOrderProduct::where('status', $type)->get();
        return view('backend.ecommerce.filter', compact('getOrders'));
    }

    //END
}
