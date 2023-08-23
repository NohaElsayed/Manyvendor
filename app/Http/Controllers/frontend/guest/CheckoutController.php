<?php

namespace App\Http\Controllers\frontend\guest;

use App\EcomProductVariantStock;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Demo;
use App\Models\District;
use App\Models\EcomCart;
use App\Models\Product;
use App\Models\VendorProductVariantStock;
use App\Vendor;
use App\VendorProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(){
        if(vendorActive()){
            return view('frontend.guest_checkout.index');
        }else{
            return view('frontend.guest_checkout.ecom_index');
        }
    }

    //data to append in checkout page
    public function indexAjaxEcommerce(Request $request){
        Artisan::call('optimize:clear');
        $discount = session()->get('coupon')['discount'] ?? 0;
        $total = session()->get('coupon')['total'] ?? 0;

        $newTotal = $total - $discount;
        $districts = District::all();

        //modifying cart items to show
        $cart_list = collect();
        $t_price = 0;

        $t_tax = 0;

        foreach ($request->carts as $key => $cart) {
            $demo_obj = new Demo;
            $product_stock = EcomProductVariantStock::where('id', $cart['vProductVS_id'])->first();
            $pro = Product::where('id', $product_stock->product_id)->first();

            $demo_obj->id = $key+1;
            $demo_obj->img = filePath($pro->image);
            $demo_obj->name = $pro->name . ' ' . Str::upper($product_stock->product_variants);
            $demo_obj->product_id = $pro->id;
            $demo_obj->product_stock_id = $product_stock->id;
            $demo_obj->sku = $pro->sku;
            $demo_obj->stock = $product_stock->quantity;

            $demo_obj->quantity = $cart['quantity'];

            if ($pro->is_discount == false) {
                /*check this product in campaign*/
                if ($cart['campaign_id'] != null) {
                    $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                    $demo_obj->campaign = $campaign->offer;
                    /*todo:cart campaign product calculation*/
                    $after_offer = ($pro->product_price + $product_stock->extra_price) -
                        (($pro->product_price + $product_stock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price = formatPrice($after_offer);
                    $demo_obj->sub_price =  $cart['quantity'] * $after_offer;
                    $demo_obj->format_sub_price = formatPrice($demo_obj->sub_price);
                    $t_price += $demo_obj->sub_price;
                    $t_tax += (($pro->tax * $demo_obj->sub_price) / 100);
                    $demo_obj->main_price = $pro->product_price + $product_stock->extra_price;
                } else {
                    $demo_obj->price = $pro->product_price + $product_stock->extra_price;
                    $demo_obj->sub_price =  $cart['quantity'] * ($pro->product_price + $product_stock->extra_price);
                    $demo_obj->format_sub_price = formatPrice($demo_obj->sub_price);
                    $t_price += $demo_obj->sub_price;
                    $t_tax += (($pro->tax * $demo_obj->sub_price) / 100);
                }

            } else {

                if ($cart['campaign_id'] != null) {
                    $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                    $demo_obj->campaign = $campaign->offer;
                    /*todo:cart campaign product calculation*/
                    $after_offer = ($pro->discount_price + $product_stock->extra_price) -
                        (($pro->discount_price + $product_stock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price = formatPrice($after_offer);
                    $demo_obj->sub_price =  $cart['quantity'] * $after_offer;
                    $demo_obj->format_sub_price = formatPrice($demo_obj->sub_price);
                    $t_price += $demo_obj->sub_price;
                    $t_tax += (($pro->tax * $demo_obj->sub_price) / 100);
                    $demo_obj->main_price = ($pro->discount_price + $product_stock->extra_price);
                } else {
                    $demo_obj->price = $pro->discount_price + $product_stock->extra_price;
                    $demo_obj->sub_price =  $cart['quantity'] * ($pro->discount_price + $product_stock->extra_price);
                    $demo_obj->format_sub_price = formatPrice($demo_obj->sub_price);
                    $t_price += $demo_obj->sub_price;
                    $t_tax += (($pro->tax * $demo_obj->sub_price) / 100);
                }
            }

            $demo_obj->url = route('single.product', [$pro->sku, $pro->slug]);
            $cart_list->push($demo_obj);
        }
        $total_price = $t_price;
        $total_tax = $t_tax;

        $formatDiscount = formatPrice($discount);
        $formatTotalPrice = formatPrice($total_price);
        $formatTotalTax = formatPrice($total_tax);
        $newTotal_sum_TotalTax = $newTotal+$total_tax;
        $formatNewTotal_sum_TotalTax = formatPrice($newTotal_sum_TotalTax);

        $totalPrice_sum_TotalTax = $total_price+$total_tax;
        $formatTotalPrice_sum_TotalTax = formatPrice($totalPrice_sum_TotalTax);

        return response([$discount,$newTotal,$districts,$total_price,$cart_list,
            $total_tax, $formatDiscount,$formatTotalPrice,$formatTotalTax,$newTotal_sum_TotalTax,
            $formatNewTotal_sum_TotalTax, $totalPrice_sum_TotalTax,$formatTotalPrice_sum_TotalTax]);
    }


    public function indexAjaxVendor(Request $request){
        Artisan::call('optimize:clear');
        $discount = session()->get('coupon')['discount'] ?? 0;
        $total = session()->get('coupon')['total'] ?? 0;

        $newTotal = $total - $discount;

        $districts = District::all();

        //modifying cart items to show
        $cart_list = collect();
        $t_price = 0;
        $t_tax = 0;
        $total_tax = 0;

        foreach ($request->carts as $key => $cart) {
            $demo_obj = new Demo;
            $vendorPStock = VendorProductVariantStock::find($cart['vProductVS_id']);
            $pro = VendorProduct::where('id', $vendorPStock->vendor_product_id)->with('product')->first();
//                $vendorPStock = VendorProductVariantStock::where('id',$vendorProductVariantStock->id)->first();
            $demo_obj->id = $key+1;
            $demo_obj->img = filePath($pro->product->image);
            $demo_obj->name = $pro->product->name . ' ' . Str::upper($vendorPStock->product_variants);
            $demo_obj->product_id = $pro->product->id;
            $demo_obj->vendor_product_id = $pro->id;
            $demo_obj->quantity = $cart['quantity'];
            $demo_obj->sku = $pro->product->sku;
            $demo_obj->stock = $vendorPStock->quantity;

            if ($pro->is_discount == false) {
                /*check this product in campaign*/
                if ($cart['campaign_id'] != null) {
                    $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                    $demo_obj->campaign = $campaign->offer;
                    /*todo:cart campaign product calculation*/
                    $after_offer = ($pro->product_price + $vendorPStock->extra_price) -
                        (($pro->product_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price = ($after_offer);
                    $demo_obj->sub_price = $cart['quantity'] * $after_offer;
                    $demo_obj->format_sub_price = formatPrice($demo_obj->sub_price);
                    $t_price += $cart['quantity'] * $after_offer;
                    $t_tax = ($total_tax+ (($pro->product->tax * $t_price) / 100));
                    $demo_obj->main_price = $pro->product_price + $vendorPStock->extra_price;
                } else {
                    $demo_obj->price = ($pro->product_price + $vendorPStock->extra_price);
                    $demo_obj->sub_price = $cart['quantity'] * ($pro->product_price + $vendorPStock->extra_price);
                    $demo_obj->format_sub_price = formatPrice($demo_obj->sub_price);
                    $t_price += $cart['quantity'] * ($pro->product_price + $vendorPStock->extra_price) ;
                    $t_tax = ($total_tax+ (($pro->product->tax * $t_price) / 100));
                }

            } else {

                if ($cart['campaign_id'] != null) {
                    $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                    $demo_obj->campaign = $campaign->offer;
                    /*todo:cart campaign product calculation*/
                    $after_offer = ($pro->discount_price + $vendorPStock->extra_price) -
                        (($pro->discount_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price = ($after_offer);
                    $demo_obj->sub_price = $cart['quantity'] * $after_offer;
                    $demo_obj->format_sub_price = formatPrice($demo_obj->sub_price);
                    $t_price += $cart['quantity'] * $after_offer;
                    $t_tax = ($total_tax+ (($pro->product->tax * $t_price) / 100));
                    $demo_obj->main_price = ($pro->discount_price +$vendorPStock->extra_price);
                } else {
                    $demo_obj->price = ($pro->discount_price + $vendorPStock->extra_price);
                    $demo_obj->sub_price = $cart['quantity'] * ($pro->discount_price +$vendorPStock->extra_price);
                    $demo_obj->format_sub_price = formatPrice($demo_obj->sub_price);
                    $t_price += $cart['quantity'] * ($pro->discount_price +$vendorPStock->extra_price);
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

        $formatDiscount = formatPrice($discount);
        $formatTotalPrice = formatPrice($total_price);
        $formatTotalTax = formatPrice($total_tax);
        $newTotal_sum_TotalTax = $newTotal+$total_tax;
        $formatNewTotal_sum_TotalTax = formatPrice($newTotal_sum_TotalTax);

        $totalPrice_sum_TotalTax = $total_price+$total_tax;
        $formatTotalPrice_sum_TotalTax = formatPrice($totalPrice_sum_TotalTax);

        return response([$discount,$newTotal,$districts,$total_price,$cart_list,
            $total_tax, $formatDiscount,$formatTotalPrice,$formatTotalTax,$newTotal_sum_TotalTax,
            $formatNewTotal_sum_TotalTax, $totalPrice_sum_TotalTax,$formatTotalPrice_sum_TotalTax]);




    }
    // END
}
