<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Mail\InvoiceMail;
use App\Models\Cart;
use App\Models\Demo;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\VendorProductVariantStock;
use App\Vendor;
use App\VendorProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TextController extends Controller
{
    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
//    return $request;
        $carts_decode = json_decode($request->carts);
        $carts_list = collect();
        foreach ($carts_decode as $cart) {
            $explode_cart = explode("-", $cart);
            $demo_cart = new Demo();
            $demo_cart->productStockId = $explode_cart[0];
            $demo_cart->campaignId = $explode_cart[1];
            $demo_cart->quantity = $explode_cart[2];
            $demo_cart->subPrice = $explode_cart[3];
            $carts_list->push($demo_cart);
        }

        $trx_id = rand(1000,99999); //generate order id
        $order_id_gen = rand(10000,99999); //generate order id
        $generate_booking_code = Carbon::now()->year . rand('1000', '99999');

        # CUSTOMER INFORMATION
        /**
         * DB::Storing to Order
         */
        $order = new Order();
        $user = Auth::user();
//        return $user;
        if($user != null){
            $order->user_id = $user->id;
            $order->phone = $user->tel_number;
            $order->email = $user->email;
        }

        $order->name = $user->name;
        // Customer Name
        $order->email =  $user->email;
        // Customer email
        $order->phone = $user->tel_number ?? 000001;
        // Customer Phone number
        $order->address = $request->address;
        // Delivery Address
        $order->division_id = $request->division_id;
        // Shipping Zone
        $order->area_id = $request->area_id;
        // Shipping Area
        $order->note = $request->note;
        // Additional note
        $order->logistic_id = $request->logistic_id;
        // logistic ID
        $order->logistic_charge = $request->logistic_charge;
        // logistic delivery charge
        $order->order_number = $order_id_gen;
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

        $order->payment_type = 'ssl-commerz'; // ssl-commerz
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

        if (!$request->has('total_price')) {
            $order_pay_amount = $request->total_price;
            // return array
        } else {
            $order_pay_amount = $request->total_price;
            // return array
        }



        $booking_code = collect();
        $invoice = collect();

        $booking_id = 0;

        foreach ($carts_list as $cart) {
            $vendorPStock = VendorProductVariantStock::where('id', $cart->productStockId)->first();
            $pro = VendorProduct::where('id', $vendorPStock->vendor_product_id)->with('product')->first();
            /*product price*/

            $order_product = new OrderProduct();
            $order_product->user_id = $user->id;
            $order_product->order_id = $order->id;                              // Order ID
            $order_product->order_number = $order->order_number;                      // Order Number
            $order_product->transaction_id = 'TrxID' . $trx_id;
            $order_product->phone = $order->phone;                                   // Customer Phone
            $order_product->booking_code = $generate_booking_code . $booking_id;      // Booking Code
            $order_product->email = $user->email;                                     // Customer email
            $order_product->product_id = $pro->product->id;                                      // Product ID
            $order_product->sku = $pro->product->sku;                                   //product sku

            $order_product->product_price = $cart->subPrice;             // Product price
            $order_product->quantity = $cart->quantity;                     // Products Quantity
            $order_product->payment_type = $request->payment;                     // Products Quantity

            $order_product->shop_id = Vendor::where('user_id',$pro->user_id)->first()->id ;                                 // Shop ID [array]
            $order_product->logistic_id = $request->logistic_id; //todo:must be edit                 // logistic ID
            $order_product->status = 'pending';
            // order status
            $order_product->save();
            $booking_id = $order_product->id;
            $booking_code->push($order_product->booking_code);
            $invoice->push($order_product);


        }




        /**
         * Generate PDF
         */
        try {
            Mail::to($user->email)->send(new InvoiceMail($user->name, $user->email, $order->order_number, $order));
        } catch (\Exception $exception) {
        }



        // Store To DB into Order:END

        $post_data = array();
        $post_data['total_amount'] = $order_pay_amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = 'TrxID' . $trx_id; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }
}
