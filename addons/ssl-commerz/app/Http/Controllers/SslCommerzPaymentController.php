<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\EcomOrder;
use App\Models\EcomOrderProduct;
use App\Models\EcomCart;
use Mail;
use App\Mail\InvoiceMail;
use App\Mail\EcomInvoiceMail;
use App\Models\OrderProduct;
use Carbon\Carbon;
use PDF;
use Session;
use Alert;

class SslCommerzPaymentController extends Controller
{

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.


        if (!vendorActive()) {
             $trx_id = rand(1000,99999); //generate order id
        $generate_order_number = Carbon::now()->year . rand('1', '10000');
        $generate_booking_code = rand('1', '1000');

        # CUSTOMER INFORMATION
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

        $order->payment_type = 'ssl-commerz';
        // Payment method

        $order->save();

        /**
         * DB::Storing to OrderProduct
         */

        $products = [1];
        // $products = $request->product_id;
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
            $order_product->transaction_id = 'TrxID' . $trx_id;                      // trx_id
            $order_product->order_number =$order->order_number;                      // Order Number
            $order_product->phone =$order->phone;                                   // Customer Phone
            $order_product->booking_code =$generate_booking_code . $booking_id;      // Booking Code
            $order_product->email =$request->email;                                     // Customer email
            $order_product->product_id = $product;                                      // Product ID
            $order_product->product_stock_id = $request->product_stock_id[$xyz];       // Product ID
            $order_product->sku = $request->sku[$xyz];                                   //product sku

            $order_product->product_price =$request->product_price[$xyz];             // Product price
            $order_product->quantity =$order_quantity[$xyz];                     // Products Quantity

            $order_product->logistic_id =$request->get_logistic_id;                 // logistic ID
            $order_product->status = 'pending';
            $order_product->payment_type = 'ssl-commerz';
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
        

        // Store To DB into Order:END
        





        // SSL COMMERZ SECTION

        $post_data = array();
        $post_data['total_amount'] = $order_pay_amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $order_product->transaction_id; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $order->name;
        $post_data['cus_email'] = $order->email;
        $post_data['cus_add1'] = $order->address;
        $post_data['cus_add2'] = $order->address;
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = $order->country;
        $post_data['cus_phone'] = $order->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = env('APP_NAME');
        $post_data['ship_add1'] = $order->address;
        $post_data['ship_add2'] = $order->address;
        $post_data['ship_city'] = $order->address;
        $post_data['ship_state'] = $order->address;
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = $order->phone;
        $post_data['ship_country'] = $order->phone;

        $post_data['shipping_method'] = "ssl-commerz";
        $post_data['product_name'] = "Goods";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "goods";

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

        // eCommerce payment::END
        }else{
            # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $trx_id = rand(1000,99999); //generate order id
        $order_id_gen = rand(10000,99999); //generate order id
        $generate_booking_code = Carbon::now()->year . rand('1000', '99999');

        # CUSTOMER INFORMATION
        /**
         * DB::Storing to Order
         */
        $order = new Order();

        if(Auth::Check()){
            $order->user_id = Auth::id();
            $order->phone = Auth::user()->tel_number;
            $order->email = Auth::user()->email;
        }else{
            $order->user_id = $order_id_gen;
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
            $order_product->transaction_id = 'TrxID' . $trx_id;                      // trx_id
            $order_product->order_number = $order->order_number;                      // Order Number
            $order_product->phone = $order->phone;                                   // Customer Phone
            $order_product->booking_code = $generate_booking_code . $booking_id;      // Booking Code
            $order_product->email = $request->email;                                     // Customer email
            $order_product->product_id = $product;                                      // Product ID
            $order_product->sku = $request->sku[$xyz];                                   //product sku

            $order_product->product_price = $request->product_price[$xyz];             // Product price
            $order_product->quantity = $order_quantity[$xyz];                     // Products Quantity

            $order_product->shop_id = $shops[$xyz] ?? NULL;                                 // Shop ID [array]
            $order_product->logistic_id = $request->get_logistic_id;                 // logistic ID
            $order_product->status = 'pending';
            $order_product->comment = 'payment pending by ssl-commerz';
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


        // Store To DB into Order:END

        $post_data = array();
        $post_data['total_amount'] = $order_pay_amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $order_product->transaction_id; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $order->name;
        $post_data['cus_email'] = $order->email;
        $post_data['cus_add1'] = $order->address;
        $post_data['cus_add2'] = $order->address;
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = $order->country;
        $post_data['cus_phone'] = $order->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = env('APP_NAME');
        $post_data['ship_add1'] = $order->address;
        $post_data['ship_add2'] = $order->address;
        $post_data['ship_city'] = $order->address;
        $post_data['ship_state'] = $order->address;
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = $order->phone;
        $post_data['ship_country'] = $order->phone;

        $post_data['shipping_method'] = "ssl-commerz";
        $post_data['product_name'] = "Goods";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "goods";

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

    public function success(Request $request)
    {
        
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

       


        if(vendorActive()){
             #Check order status in order tabel against the transaction id or order id.
            $order_detials = OrderProduct::where('transaction_id', $tran_id)
                                    ->select('transaction_id', 'status', 'payment_type')->first();
        }else{
            #Check order status in order tabel against the transaction id or order id.
            $order_detials = EcomOrderProduct::where('transaction_id', $tran_id)
                                    ->select('transaction_id', 'status', 'payment_type')->first();
        }

        if ($order_detials->status == 'pending') {
            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */

                if (vendorActive()) {
                    $update_product = DB::table('order_products')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'confirmed', 'payment_type' => 'ssl-commerz']);
    
                    $order_booking_codes = OrderProduct::where('transaction_id', $tran_id)->get();
                    return view('frontend.checkout.success', compact('order_booking_codes'));
                }else{
                    $update_product = DB::table('ecom_order_products')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'confirmed', 'payment_type' => 'ssl-commerz']);
    
                    $order_booking_codes = EcomOrderProduct::where('transaction_id', $tran_id)->get();
                    return view('frontend.checkout.success', compact('order_booking_codes'));
                }


            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */

                if (vendorActive()) {
                    $update_product = DB::table('order_products')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'canceled']);
                    Alert::error('Validation Fail', 'Try again');
                    return redirect()->route('homepage');
                }else{
                    $update_product = DB::table('ecom_order_products')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'canceled']);
                    Alert::error('Validation Fail', 'Try again');
                    return redirect()->route('homepage');
                }
                
            }
        } else if ($order_detials->status == 'confirmed' || $order_detials->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            if (vendorActive()) {
                $order_booking_codes = OrderProduct::where('transaction_id', $tran_id)->get();
            }else{
                $order_booking_codes = EcomOrderProduct::where('transaction_id', $tran_id)->get();
            }
            

                return view('frontend.checkout.success', compact('order_booking_codes'));
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            Alert::error('Invalid Transaction', 'Try again');
            return redirect()->route('homepage');
        }


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        if (vendorActive()) {
            $order_detials = DB::table('order_products')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status')->first();

            if ($order_detials->status == 'pending') {
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'canceled']);
                Alert::error('Transaction is Falied', 'Try again');
                return redirect()->route('homepage');
            } else if ($order_detials->status == 'confirmed') {
                Alert::info('Transaction is already Successful', 'Thank you');
                return redirect()->route('homepage');
            } else {
                Alert::warning('Transaction is Invalid', 'Try Again');
                return redirect()->route('homepage');
            }
        }else{
            $order_detials = DB::table('ecom_order_products')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status')->first();

            if ($order_detials->status == 'pending') {
                $update_product = DB::table('ecom_order_products')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'canceled']);
                Alert::error('Transaction is Falied', 'Try again');
                return redirect()->route('homepage');
            } else if ($order_detials->status == 'confirmed') {
                Alert::info('Transaction is already Successful', 'Thank you');
                return redirect()->route('homepage');
            } else {
                Alert::warning('Transaction is Invalid', 'Try Again');
                return redirect()->route('homepage');
            }
        }

        

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');


        if (vendorActive()) {
            $order_detials = DB::table('order_products')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id')->first();

            if ($order_detials->status == 'pending') {
                $update_product = DB::table('order_products')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'canceled']);
                Alert::error('Transaction is Cancel', 'Try Again');
                return redirect()->route('homepage');
            } else if ($order_detials->status == 'confirmed') {
                Alert::info('Transaction is already Successful', 'Thank you');
                return redirect()->route('homepage');
            } else {
                Alert::info('Transaction is Invalid', 'Try Again');
                return redirect()->route('homepage');
            }
        }else{
            $order_detials = DB::table('ecom_order_products')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id')->first();

            if ($order_detials->status == 'pending') {
                $update_product = DB::table('ecom_order_products')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'canceled']);
                Alert::error('Transaction is Cancel', 'Try Again');
                return redirect()->route('homepage');
            } else if ($order_detials->status == 'confirmed') {
                Alert::info('Transaction is already Successful', 'Thank you');
                return redirect()->route('homepage');
            } else {
                Alert::info('Transaction is Invalid', 'Try Again');
                return redirect()->route('homepage');
            }
        }
        


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.

            if (vendorActive()) {
                $order_details = DB::table('order_products')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status')->first();

                if ($order_details->status == 'pending') {
                    $sslc = new SslCommerzNotification();
                    $validation = $sslc->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                    if ($validation == TRUE) {
                        /*
                        That means IPN worked. Here you need to update order status
                        in order table as Processing or Complete.
                        Here you can also sent sms or email for successful transaction to customer
                        */
                        $update_product = DB::table('order_products')
                            ->where('transaction_id', $tran_id)
                            ->update(['status' => 'confirmed']);

                        $order_booking_codes = OrderProduct::where('transaction_id', $tran_id)->get();

                    return view('frontend.checkout.success', compact('order_booking_codes'));
                    } else {
                        /*
                        That means IPN worked, but Transation validation failed.
                        Here you need to update order status as Failed in order table.
                        */
                        $update_product = DB::table('order_products')
                            ->where('transaction_id', $tran_id)
                            ->update(['status' => 'canceled']);

                        Alert::warning('Validation Fail', 'Try Again');
                return redirect()->route('homepage');
                    }

                } else if ($order_details->status == 'confirmed') {

                    #That means Order status already updated. No need to udate database.

                    Alert::warning('Transaction is already successfully Completed', 'Thank you');
                return redirect()->route('homepage');
                } else {
                    #That means something wrong happened. You can redirect customer to your product page.

                    Alert::error('Invalid Transaction', 'Try Again');
                return redirect()->route('homepage');
                }
            }else{
                $order_details = DB::table('ecom_order_products')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status')->first();

                if ($order_details->status == 'pending') {
                    $sslc = new SslCommerzNotification();
                    $validation = $sslc->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                    if ($validation == TRUE) {
                        /*
                        That means IPN worked. Here you need to update order status
                        in order table as Processing or Complete.
                        Here you can also sent sms or email for successful transaction to customer
                        */
                        $update_product = DB::table('ecom_order_products')
                            ->where('transaction_id', $tran_id)
                            ->update(['status' => 'confirmed']);

                        $order_booking_codes = OrderProduct::where('transaction_id', $tran_id)->get();

                    return view('frontend.checkout.success', compact('order_booking_codes'));
                    } else {
                        /*
                        That means IPN worked, but Transation validation failed.
                        Here you need to update order status as Failed in order table.
                        */
                        $update_product = DB::table('ecom_order_products')
                            ->where('transaction_id', $tran_id)
                            ->update(['status' => 'canceled']);

                        Alert::warning('Validation Fail', 'Try Again');
                return redirect()->route('homepage');
                    }

                } else if ($order_details->status == 'confirmed') {

                    #That means Order status already updated. No need to udate database.

                    Alert::warning('Transaction is already successfully Completed', 'Thank you');
                return redirect()->route('homepage');
                } else {
                    #That means something wrong happened. You can redirect customer to your product page.

                    Alert::error('Invalid Transaction', 'Try Again');
                return redirect()->route('homepage');
                }
            }

        } else {
            echo "Invalid Data";
            Alert::warning('Invalid Data', 'Try Again');
            return redirect()->route('homepage');
        }
    }
}
