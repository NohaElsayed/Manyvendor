<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PaytmWallet;
use Auth;
use App\Models\Cart;
use App\Models\Order;
use Mail;
use App\Mail\InvoiceMail;
use App\Models\OrderProduct;
use Carbon\Carbon;
use PDF;
use Session;

class PaytmController extends Controller
{


    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function eventOrderGen(Request $request)
    {

        $input = $request->all();
        $input['order_id'] = rand(10000,99999); //generate order id
        $generate_booking_code = Carbon::now()->year . rand('1000', '99999');
        
 
        // Store To DB into Order
        
        /**
         * DB::Storing to Order
         */
        $order = new Order();

        if(Auth::Check()){
            $order->user_id = Auth::id();
            $order->phone = Auth::user()->tel_number;
            $order->email = Auth::user()->email;
        }else{
          $order->user_id = $input['order_id'];
          $order->phone = $request->phone;
          $order->email = $request->email;
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
        $order->order_number = $input['order_id'];
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

        $order->payment_type = 'paytm'; // paytm
        // Payment method
        $order->save();


        
        $input['amount'] = $order->pay_amount;

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
            $order_product->user_id = $order->user_id; //user_id
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
            $order_product->comment = 'payment pending by Paytm';
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
        
        // Store To DB into Order:END
 
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => $order->order_number, // order id
          'user' => $order->user_id, //user id
          'mobile_number' => $order->phone, // user phone number
          'email' => $order->email, //user email
          'amount' => $input['amount'], // paid amount
          'callback_url' => route('paytm.callback')
        ]);
        return $payment->receive();
    }
 
    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
 
        $response = $transaction->response();
 
        if($transaction->isSuccessful()){

          $success_payment = Order::where('order_number', $response['ORDERID'])->first();
          $success_payment->payment_type = 'paytm';
          $success_payment->save();

          $success_payment_order = OrderProduct::where('order_number', $response['ORDERID'])->first();
          $success_payment_order->payment_type = 'paytm';
          $success_payment_order->status = 'confirmed';
          $success_payment_order->comment = 'Paid by Paytm';
          $success_payment_order->save();

          /**
         * Empty Cart
         */

        if(Auth::Check()){
            Cart::where('user_id', Auth::user()->id)->delete();
        }

          return redirect()->route('order.success');
 
        }else if($transaction->isFailed()){

          $success_payment_order = OrderProduct::where('order_number', $response['ORDERID'])->first();
          $success_payment_order->payment_type = 'paytm';
          $success_payment_order->status = 'canceled';
          $success_payment_order->comment = 'Not Paid by Paytm';
          $success_payment_order->save();

          dd('Payment Failed. Try again later');
        }
    }  
    //END
}





