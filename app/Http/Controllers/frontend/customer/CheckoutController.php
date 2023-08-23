<?php

namespace App\Http\Controllers\frontend\customer;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Cart;
use App\Models\VendorProductVariantStock;
use App\Vendor;
use App\VendorProduct;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\District;
use App\Models\Thana;
use App\Models\LogisticArea;
use App\Models\Logistic;
use App\Models\Demo;
use Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{

    public function index(Request $request){

        $discount = session()->get('coupon')['discount'] ?? 0;
        $total = session()->get('coupon')['total'] ?? 0;

        $newTotal = $total - $discount;

        $districts = District::all();

        $carts = Cart::where('user_id', Auth::id())->get();
        //modifying cart items to show
        $cart_list = collect();
        $t_price = 0;


        $t_tax = 0;
        $total_tax = 0;

        foreach ($carts as $cart) {
            $demo_obj = new Demo;
            $pro = VendorProduct::where('id', $cart->vendor_product_id)->with('product')->first();
            $vendorPStock = VendorProductVariantStock::where('id', $cart->vpvs_id)->first();
            $demo_obj->id = $cart->id;
            $demo_obj->img = filePath($pro->product->image);
            $demo_obj->name = $pro->product->name . ' ' . Str::upper($vendorPStock->product_variants);
            $demo_obj->product_id = $pro->product->id;
            $demo_obj->vendor_product_id = $pro->id;
            $demo_obj->sku = $pro->product->sku;
            $demo_obj->stock = $vendorPStock->quantity;

            $demo_obj->quantity = $cart->quantity;

            if ($pro->is_discount == false) {
                /*check this product in campaign*/
                if ($cart->campaign_id != null) {
                    $campaign = Campaign::where('id', $cart->campaign_id)->first();
                    $demo_obj->campaign = $campaign->offer;
                    /*todo:cart campaign product calculation*/
                    $after_offer = ($pro->product_price + $vendorPStock->extra_price) -
                        (($pro->product_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price = ($after_offer);
                    $demo_obj->sub_price = $cart->quantity * $after_offer;
                    $t_price += $cart->quantity * $after_offer;
                    $t_tax = ($total_tax+ (($pro->product->tax * $t_price) / 100));
                    $demo_obj->main_price = $pro->product_price + $vendorPStock->extra_price;
                } else {
                    $demo_obj->price = ($pro->product_price + $vendorPStock->extra_price);
                    $demo_obj->sub_price = $cart->quantity * ($pro->product_price + $vendorPStock->extra_price);
                    $t_price += $cart->quantity * ($pro->product_price + $vendorPStock->extra_price) ;
                    $t_tax = ($total_tax+ (($pro->product->tax * $t_price) / 100));
                }

            } else {

                if ($cart->campaign_id != null) {
                    $campaign = Campaign::where('id', $cart->campaign_id)->first();
                    $demo_obj->campaign = $campaign->offer;
                    /*todo:cart campaign product calculation*/
                    $after_offer = ($pro->discount_price + $vendorPStock->extra_price) -
                        (($pro->discount_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price = ($after_offer);
                    $demo_obj->sub_price = $cart->quantity * $after_offer;
                    $t_price += $cart->quantity * $after_offer;
                    $t_tax = ($total_tax+ (($pro->product->tax * $t_price) / 100));
                    $demo_obj->main_price = ($pro->discount_price +$vendorPStock->extra_price);
                } else {
                    $demo_obj->price = ($pro->discount_price + $vendorPStock->extra_price);
                    $demo_obj->sub_price = $cart->quantity * ($pro->discount_price +$vendorPStock->extra_price);
                    $t_price += $cart->quantity * ($pro->discount_price +$vendorPStock->extra_price);
                    $t_tax = ($total_tax+ (($pro->product->tax * $t_price) / 100));
                }
            }

            $demo_obj->url = route('single.product',[$pro->product->sku,$pro->product->slug]);
            $demo_obj->shop_name = Vendor::where('user_id', $pro->user_id)->first()->shop_name;
            $demo_obj->vendor_id = Vendor::where('user_id', $pro->user_id)->first()->id;
            $cart_list->push($demo_obj);
        }
        $total_price = $t_price;
        $total_tax = $t_tax;

        

        return view('frontend.checkout.index',compact('discount','newTotal','districts','total_price','cart_list', 'total_tax'));
    }


    public function coupon_store(Request $request)
    {
      $coupon = Coupon::where('code',$request->code)->Published()->first();

      $auth = Auth::check();
      if($auth == true){
          $checkout_route = 'checkout.index';
      }else{
          $checkout_route = 'guest.checkout.index';
      }

      if ($coupon) {
          $start_day  = Carbon::create(Coupon::where('code',$request->code)->Published()->first()->start_day);
          $end_day    = Carbon::create(Coupon::where('code',$request->code)->Published()->first()->end_day);
          $min_value  = Coupon::where('code',$request->code)->Published()->first()->min_value;

         if (Carbon::now() > $start_day && Carbon::now() < $end_day) {
           if ($min_value <= $request->total) {
             session()->put('coupon',[
               'name' => $coupon->code,
               'discount' => $coupon->discount($coupon->rate),
               'total' => $request->total,
             ]);
             return redirect()->route($checkout_route)->withSuccess(translate('Coupon applied'));
           }else {
             return redirect()->route($checkout_route)->withErrors('Minimum Amount '. ' ' . $min_value . ' '  .'needed');
           }
        }
        else {
          return redirect()->route($checkout_route)->withErrors(translate('Coupon expired.'));
        }
      }else {
        return redirect()->route($checkout_route)->withErrors(translate('Invalid Coupon Code.'));
      }
    }

    // coupon_destroy
    public function coupon_destroy(Request $request)
    {
      session()->forget(['coupon']);
      return redirect()->route('checkout.index')->withSuccess('Coupon removed');
    }

    // get_logistics
    public function get_logistics(Request $request)
    {

      $logistics = LogisticArea::where('division_id',$request->division)
                  ->Active()
                  ->get();

      $dataSend = collect();

      foreach ($logistics as $logistic) {
        $x = json_decode($logistic->area_id);
        foreach ($x as $area) {
          if ($area == $request->area) {
            $vf =Logistic::where('id',$logistic->logistic_id)->first();
            $demo = new Demo();
            $demo->rate =$logistic->rate;
            $demo->id =$vf->id;
            $demo->name =$vf->name;
            $demo->min =$logistic->min;
            $demo->max =$logistic->max;
            $dataSend->push($demo);
          }
        }
      }
      $send = '';
      foreach ($dataSend as $value) {

        $url = route('checkout.get.total.amount');

        $formatePrice = formatPrice($value->rate);

        $send .= "
        <div class='form-group p-lr-10'>
          <div class='row'>
            <div class='col-md-6'>
            <input type='hidden' class='logistic_url' value='$url'>
              <div class='ps-radio'>
                <input name='logistic' value='$value->id'>
                <input required class='form-control logistic_id' onclick='myLogistic(this)' type='radio' value='$value->rate' name='logistic_id' data-logisticId='$value->id' data-id='shipping$value->id' id='shipping$value->id'>
                <label for='shipping$value->id'>$value->name ($value->min to $value->max days)</label>
              </div>
            </div>
            <div class='col-md-6 text-right'>
              $formatePrice
            </div>
          </div>
        </div>
            ";
      }
      return $send;
    }

    // get_total_amount
    public function get_total_amount(Request $request)
    {
      $amount = $request->amount;
      $forLogisticsAmount = $request->forLogisticsAmount;
      $shipping_amount = $request->shipping_amount;
      $result = $shipping_amount + $forLogisticsAmount;
      return response()
              ->json([
                "data" => formatPrice($result),
                "data2"=> $result
              ],200);
    }
    // END
}
