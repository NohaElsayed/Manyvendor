<?php

namespace App\Http\Controllers\backend\order;

use App\DeliverAssign;
use App\DeliverUser;
use App\DeliveymenTrack;
use App\Http\Controllers\Controller;
use App\Models\AdminCommission;
use App\Models\Product;
use App\Models\SellerEarning;
use App\Models\VendorProductVariantStock;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Notification;
use Alert;
use App\User;
use App\Models\OrderProduct;
use App\Notifications\OrderNotification;

class OrderController extends Controller
{

    /**
     * TOTAL ORDER
     */

    public function index(Request $request)
    {

        if (Auth::user()->user_type == 'Vendor') {
            $vendor = Vendor::where('user_id', Auth::id())->first();
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
                        $orders = OrderProduct::whereBetween('created_at', [$start, $end])->where('shop_id', $vendor->id)->latest()->get();
                    } else {
                        $orders = OrderProduct::where($condition)->whereBetween('created_at', [$start, $end])->where('shop_id', $vendor->id)->latest()->get();

                    }

                } else {
                    $orders = OrderProduct::where($condition)->where('shop_id', $vendor->id)->latest()->get();
                }
            } else {
                $orders = OrderProduct::where('shop_id', $vendor->id)->latest()->paginate(20);
            }
        }
        else {
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
                        $orders = OrderProduct::whereBetween('created_at', [$start, $end])->get();
                    } else {
                        $orders = OrderProduct::where($condition)->whereBetween('created_at', [$start, $end])->latest()->get();

                    }

                } else {
                    $orders = OrderProduct::where($condition)->latest()->get();
                }
            } else {
                $orders = OrderProduct::latest()->paginate(50);
            }
        }

        $vendor = Vendor::where('user_id', Auth::id())->first();
        return view('backend.orders.index', compact('orders', 'vendor'));
    }

    /**
     * CONFIRM
     */

    public function confirm($id)
    {
        $confirm = OrderProduct::findOrFail($id);
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
            } catch (\Exception $exception) {
            }
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
        $first_time = false;
        $cancel = OrderProduct::findOrFail($id);
        if (is_null($cancel->status) || $cancel->status == 'confirmed') {
            $first_time = true;
        }
        $cancel->status = 'canceled';
        $cancel->comment = 'Order Canceled';
        $cancel->commentedBy = Auth::user()->id;
        $cancel->save();
        if ($first_time) {
            $stock = VendorProductVariantStock::where('id', $cancel->product_id)->first();
            $stock->quantity += $cancel->quantity;
            $stock->save();
        }

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
        } catch (\Exception $exception) {
        }


        return back();
    }

    /**
     * processing
     */

    public function processing($id)
    {
        $cancel = OrderProduct::findOrFail($id);
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
        } catch (\Exception $exception) {
        }

        return back();
    }

    /**
     * quality_check
     */

    public function quality_check($id)
    {
        $cancel = OrderProduct::findOrFail($id);
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
        } catch (\Exception $exception) {
        }

        return back();
    }

    /**
     * product_dispatched
     */

    public function product_dispatched($id)
    {
        $cancel = OrderProduct::findOrFail($id);
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
        } catch (\Exception $exception) {
        }


        return back();
    }

    /**
     * delivered
     */

    public function delivered($id)
    {
        $cancel = OrderProduct::findOrFail($id);
        if (deliverActive()){
            /*here order confirm by deliver*/
            $assign = DeliverAssign::where('order_id',$id)->where('deliver_user_id',Auth::id())->first();
            if ($assign != null){
                $assign->delivered = true;
                $assign->save();
                if ($cancel->status != 'cancel' || $cancel->status != 'follow_up' || $cancel->status == "delivered") {
                    $cancel->status = 'delivered';
                    $cancel->comment = 'Product Delivered';
                    $cancel->commentedBy = Auth::user()->id;
                    $cancel->save();


                    /*here are the commission*/
                    $stock = VendorProductVariantStock::where('id', $cancel->product_id)->first();
                    $product = Product::where('id', $stock->product_id)->with('childcategory')->first();
                    /*here the stock manage*/
                    $stock->quantity -= $cancel->quantity;
                    $stock->save();
                    /*todo::save admin commission*/
                    $check = AdminCommission::where('order_product_id', $cancel->id)->first();
                    if (empty($check)) {
                        $admin_commission = new AdminCommission();
                        $admin_commission->booking_code = $cancel->booking_code;
                        $admin_commission->order_product_id = $cancel->id;
                        $admin_commission->category_id = $product->childcategory->id;
                        $admin_commission->confirm_by = \Illuminate\Support\Facades\Auth::id();
                        $admin_commission->price = $cancel->product_price;
                        if($product->childcategory->commission){
                            $admin_commission->percentage = $product->childcategory->commission->amount;
                        }else{
                            $admin_commission->percentage = 0;
                        }
                        /*commission here*/
                        if($product->childcategory->commission){
                            $commission = ($admin_commission->price * $product->childcategory->commission->amount) / 100;
                        }else{
                            $commission = 0;
                        }
                        $admin_commission->commission = $commission;
                        $admin_commission->save();


                        /*vendor data*/
                        $vendor = Vendor::where('id', $cancel->shop_id)->first();
                        /*todo:: seller balance add*/
                        $get_amount = ($admin_commission->price - $commission);
                        $seller_earning = new SellerEarning();
                        $seller_earning->booking_code = $cancel->booking_code;
                        $seller_earning->order_product_id = $cancel->id;
                        $seller_earning->category_id = $product->childcategory->id;
                        $seller_earning->vendor_id = $vendor->id;
                        $seller_earning->user_id = $vendor->user_id;
                        $seller_earning->vendor_product_stock_id = $stock->id;
                        $seller_earning->vendor_product_id = $stock->vendor_product_id;
                        $seller_earning->product_id = $stock->product_id;
                        $seller_earning->commission_pay = $commission;
                        $seller_earning->price = $admin_commission->price;
                        $seller_earning->get_amount = $get_amount;
                        $seller_earning->save();

                        /*vendor balance*/
                        $vendor->balance += $get_amount;
                        $vendor->save();
                    }


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
            if ($cancel->status != 'cancel' || $cancel->status != 'follow_up' || $cancel->status == "delivered") {
                $cancel->status = 'delivered';
                $cancel->comment = 'Product Delivered';
                $cancel->commentedBy = Auth::user()->id;
                $cancel->save();
                /*here order confirm by deliver*/


                /*here are the commission*/
                $stock = VendorProductVariantStock::where('id', $cancel->product_id)->first();
                $product = Product::where('id', $stock->product_id)->with('childcategory')->first();
                /*here the stock manage*/
                $stock->quantity -= $cancel->quantity;
                $stock->save();
                /*todo::save admin commission*/
                $check = AdminCommission::where('order_product_id', $cancel->id)->first();
                if (empty($check)) {
                    $admin_commission = new AdminCommission();
                    $admin_commission->booking_code = $cancel->booking_code;
                    $admin_commission->order_product_id = $cancel->id;
                    $admin_commission->category_id = $product->childcategory->id;
                    $admin_commission->confirm_by = \Illuminate\Support\Facades\Auth::id();
                    $admin_commission->price = $cancel->product_price;

                    if($product->childcategory->commission) {
                        $admin_commission->percentage = $product->childcategory->commission->amount;
                        /*commission here*/
                        $commission = ($admin_commission->price * $product->childcategory->commission->amount) / 100;
                    }else{
                        $commission = 0;
                    }
                    $admin_commission->commission = $commission;
                    $admin_commission->save();


                    /*vendor data*/
                    $vendor = Vendor::where('id', $cancel->shop_id)->first();
                    /*todo:: seller balance add*/
                    $get_amount = ($admin_commission->price - $commission);
                    $seller_earning = new SellerEarning();
                    $seller_earning->booking_code = $cancel->booking_code;
                    $seller_earning->order_product_id = $cancel->id;
                    $seller_earning->category_id = $product->childcategory->id;
                    $seller_earning->vendor_id = $vendor->id;
                    $seller_earning->user_id = $vendor->user_id;
                    $seller_earning->vendor_product_stock_id = $stock->id;
                    $seller_earning->vendor_product_id = $stock->vendor_product_id;
                    $seller_earning->product_id = $stock->product_id;
                    $seller_earning->commission_pay = $commission;
                    $seller_earning->price = $admin_commission->price;
                    $seller_earning->get_amount = $get_amount;
                    $seller_earning->save();

                    /*vendor balance*/
                    $vendor->balance += $get_amount;
                    $vendor->save();
                }


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
        $followup = OrderProduct::where('id', $id)->first();
        return view('backend.orders.followup_modal', compact('followup'));
    }

    /**
     * FOLLOW UP COMMENT
     */

    public function followup_comment(Request $request, $id)
    {
        $first_time = false;
        $followup_comment = OrderProduct::findOrFail($id);
        if ($followup_comment->status == 'delivered') {
            $first_time = true;
        }
        $followup_comment->status = 'follow_up';
        $followup_comment->comment = $request->comment;
        $followup_comment->commentedBy = Auth::user()->id;
        $followup_comment->save();

        /*delete the assign data*/
        $deliver = DeliverAssign::where('order_id',$id)->first();
        if($deliver != null){
            $deliver->delete();
        }

        $deliverTrack = DeliveymenTrack::where('order_id',$id)->first();
        if($deliverTrack != null){
            $deliverTrack->delete();
        }
        if ($first_time) {
            /*here are the commission*/
            $stock = VendorProductVariantStock::where('id', $followup_comment->product_id)->first();
            $stock->quantity += $followup_comment->quantity;
            $stock->save();
            /*todo::save admin commission*/
            $admin_commission = AdminCommission::where('order_product_id', $followup_comment->id)->first();

            /*vendor data*/
            $vendor = Vendor::where('id', $followup_comment->shop_id)->first();

            /*todo:: seller balance add*/
            $get_amount = ($admin_commission->price - $admin_commission->commission);
            SellerEarning::where('order_product_id', $followup_comment->id)->first();

            /*vendor balance*/
            $vendor->balance -= $get_amount;
            $vendor->save();

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
        if (Auth::user()->user_type == 'Vendor') {
            $vendor = Vendor::where('user_id', Auth::id())->first();
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
                    $getDatas = OrderProduct::where('shop_id', $vendor->id)->whereBetween('created_at', [$start, $end])->get();
                } else {
                    $getDatas = OrderProduct::where('shop_id', $vendor->id)->where($condition)->whereBetween('created_at', [$start, $end])->get();
                }

            } else {
                $getDatas = OrderProduct::where('shop_id', $vendor->id)->where($condition)->get();
            }
        } else {
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
                    $getDatas = OrderProduct::whereBetween('created_at', [$start, $end])->get();
                } else {
                    $getDatas = OrderProduct::where($condition)->whereBetween('created_at', [$start, $end])->get();
                }

            } else {
                $getDatas = OrderProduct::where($condition)->get();
            }
        }


        return view('backend.orders.search_result', compact('getDatas'));

    }

    /**
     * FILTER ORDER
     */

    public function filter($type)
    {
        $vendor = Vendor::where('user_id', Auth::id())->first();
        if ($vendor != null) {
            $getOrders = OrderProduct::where('shop_id', $vendor->id)->where('status', $type)->get();
        } else {
            $getOrders = OrderProduct::where('status', $type)->get();
        }

        return view('backend.orders.filter', compact('getOrders', 'vendor'));
    }

    //END
}
