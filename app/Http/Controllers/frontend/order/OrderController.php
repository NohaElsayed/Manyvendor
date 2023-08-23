<?php

namespace App\Http\Controllers\frontend\order;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\InvoiceMail;
use App\Models\OrderProduct;
use Carbon\Carbon;
use PDF;
use Session;

class OrderController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /**
         * Generate Order number
         */
        $generate_order_number = Carbon::now()->year . rand('1', '10000');
        $generate_booking_code = Carbon::now()->year . rand('1', '1000');

        /**
         * DB::Storing to Order
         */
        $order = new Order();
        if(Auth::Check()){
            $order->user_id = Auth::id();
        }

        $order->name = $request->name;
        // Customer Name
        $order->email = $request->email;
        // Customer email
        $order->phone = $request->phone;
        // Customer Phone number
        $order->address = $request->address;
        // Delivery Address
        $order->division_id = $request->division_id;
        // Shipping Zone
        $order->area_id = $request->area_id;
        // Shipping Area
        $order->note = $request->note;
        // Additional note
        $order->logistic_id = $request->get_logistic_id;
        // logistic ID
        $order->logistic_charge = $request->get_shipping_value;
        // logistic delivery charge
        $order->order_number = $generate_order_number;
        // order number

        if ($request->has('applied_coupon')) {
            $order->applied_coupon = $request->applied_coupon;
            // Applied coupon
        } else {
            $order->applied_coupon = null;
            // No Coupon Applied
        }

        if (!$request->has('payable_amount')) {
            $order->pay_amount = $request->pay_amount;
            // Payment Amount
        } else {
            $order->pay_amount = $request->payable_amount;
            // Payment Amount
        }

        $order->payment_type = 'cod';
        // Payment method
        $order->save();

        /**
         * DB::Storing to OrderProduct
         */

        $products = $request->product_id;
        // return array
        $shops = $request->shop_id;
        // return array


        if (!$request->has('payable_amount')) {
            $order_pay_amount = $request->pay_amount;
            // return array
        } else {
            $order_pay_amount = $request->payable_amount;
            // return array
        }

        $xyz = 0;

        $booking_code = collect();
        $invoice = collect();

        $booking_id = 0;

        foreach ($products as $product) {
            $order_product = new OrderProduct();
            $order_product->user_id = Auth::id();
            $order_product->order_id = $order->id;                              // Order ID
            $order_product->order_number = $order->order_number;                      // Order Number
            $order_product->phone = $order->phone;                                   // Customer Phone
            $order_product->booking_code = $generate_booking_code . $booking_id;      // Booking Code
            $order_product->email = $request->email;                                     // Customer email
            $order_product->product_id = $product;                                      // Product ID
            $order_product->sku = $request->sku[$xyz];                                   //product sku

            $order_product->product_price = $request->product_price[$xyz];             // Product price
            $order_product->quantity = $request->quantity[$xyz];                     // Products Quantity

            $order_product->shop_id = $shops[$xyz];                                 // Shop ID [array]
            $order_product->logistic_id = $request->get_logistic_id;                 // logistic ID
            $order_product->status = 'pending';
            // order status
            $order_product->save();

            $booking_id = $order_product->id;

            $booking_code->push($order_product->booking_code);
            $invoice->push($order_product);

            $xyz++;
        }

        // form data
        $email = $request->email;
        $name = $request->name;
        $invoice_number = $order->order_number;

        /**
         * Empty Cart
         */

        if(Auth::Check()){
            Cart::where('user_id', Auth::user()->id)->delete();
        }

        /**
         * Generate PDF
         */
        try {
            Mail::to($email)->send(new InvoiceMail($name, $email, $invoice_number, $order));
        } catch (\Exception $exception) {
        }

        Session::forget('coupon');
        Session::put('booking', $booking_code);
        return redirect()->route('order.success');
    }

    /**
     * SUCCESS
     */

    public function success(Request $request)
    {
        $booking_codes = $request->session()->get('booking');
        return view('frontend.checkout.success', compact('booking_codes'));
    }

    /**
     * Customer Order Details
     */

    public function order_details($order_number)
    {
        $order_detail = Order::where('order_number', $order_number)
            ->where('user_id', auth()->id())
            ->with('order_product')
            ->with('logistic')
            ->first();

        return view('frontend.order.order_details', compact('order_detail'));
    }

    /**
     * Customer Order
     */

    public function your_orders()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('frontend.order.your_order', compact('orders'));
    }

    /**
     * Track Order
     */

    public function track_order(Request $request)
    {
        return view('frontend.order.track_order');
    }

    /**
     * Tracking Order through profile
     */

    public function tracking_order_number($code)
    {
        return view('frontend.order.track_order', compact('code'));
    }

    /**
     * Track Order Result
     */

    public function track_order_number(Request $request)
    {
        $order_result = OrderProduct::where('booking_code', $request->order_number)
            ->where('email', $request->email)
            ->with('logistic')
            ->first();
        if ($order_result) {
            return response()->json($order_result, 200);
        } else {
            return 'No result found';
        }
    }

    /**
     * END
     */
}
