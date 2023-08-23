<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\EcomInvoiceMail;
use App\Models\EcomOrder;
use App\Models\EcomOrderProduct;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\EcomCart;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use PDF;
use Mail;
use App\Mail\InvoiceMail;
use App\Models\OrderProduct;
use Session;

class PaymentsController extends Controller
{
    /*this is for paypal payment*/
    public function paypalPayment(Request $request)
    {
        /*put session*/

        /**
         * Generate Order number
         */
        $generate_order_number = Carbon::now()->year . rand('1', '10000');
        $generate_booking_code = Carbon::now()->year . rand('1', '1000');

        if(vendorActive()){
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
        // logistic delivery charfe
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

        $order->payment_type = 'paypal';
        // Payment method
        $order->save();

        /**
         * DB::Storing to OrderProduct
         */

        $products = $request->product_id;
        // return array
        $shops = $request->shop_id;
        // return array
        $order_quantity = $request->quantity;
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
            $order_product->quantity = $order_quantity[$xyz];                     // Products Quantity

            $order_product->shop_id = $shops[$xyz];                                 // Shop ID [array]
            $order_product->logistic_id = $request->get_logistic_id;                 // logistic ID
            $order_product->status = 'pending';
            $order_product->payment_type = 'paypal';
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
         * Invoice Mail
         */
        try {
            Mail::to($email)->send(new InvoiceMail($name, $email, $invoice_number, $order));
        } catch (\Exception $exception) {
        }
        Session::forget('coupon');
        $request->session()->put('payment', 'Paypal');
        Session::put('booking', $booking_code);
        return redirect()->route('order.success');
        }else{
            /**
         * DB::Storing to Order
         */
        $order = new EcomOrder();
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
        // logistic delivery charfe
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

        $order->payment_type = 'paypal';
        // Payment method
        $order->save();

        /**
         * DB::Storing to OrderProduct
         */

        $products = $request->product_id;
        // return array
        $shops = $request->shop_id;
        // return array
        $order_quantity = $request->quantity;
        // return array

        if (!$request->has('payable_amount')) {
            $order_pay_amount = $request->pay_amount;
        } else {
            $order_pay_amount = $request->payable_amount;
        }

        $xyz = 0;

        $booking_code = collect();
        $invoice = collect();

        $booking_id = 0;

        foreach ($products as $product) {

            $order_product = new EcomOrderProduct();
            $order_product->user_id = Auth::id();
            $order_product->order_id = $order->id;                              // Order ID
            $order_product->order_number =$order->order_number;                      // Order Number
            $order_product->phone =$order->phone;                                   // Customer Phone
            $order_product->booking_code =$generate_booking_code . $booking_id;      // Booking Code
            $order_product->email =$request->email;                                     // Customer email
            $order_product->product_id = $product;                                      // Product ID
            $order_product->product_stock_id = $request->product_stock_id[$xyz];                                      // Product ID
            $order_product->sku = $request->sku[$xyz];                                   //product sku

            $order_product->product_price =$request->product_price[$xyz];             // Product price
            $order_product->quantity =$order_quantity[$xyz];                     // Products Quantity

            $order_product->logistic_id =$request->get_logistic_id;                 // logistic ID
            $order_product->status = 'pending';
            $order_product->payment_type = 'paypal';
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
            EcomCart::where('user_id', Auth::user()->id)->delete();
        }




            /**
         * Invoice Mail
         */
       /*todo:Ecommerce InvoiceMail*/
        try {
            Mail::to($email)->send(new EcomInvoiceMail($name, $email ,$invoice_number, $order));
        }catch (\Exception $exception){}
        Session::forget('coupon');
        Session::put('booking', $booking_code);
        return redirect()->route('order.success');
        }
    }

    // END

}
