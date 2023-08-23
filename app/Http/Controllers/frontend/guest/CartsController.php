<?php

namespace App\Http\Controllers\frontend\guest;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Cart;
use App\Models\Demo;
use App\Models\VendorProductVariantStock;
use App\Vendor;
use App\VendorProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartsController extends Controller
{
    //all cart items
    public function index(Request $request)
    {
        //modifying cart items to show in cart btn hover
        $cart_list = collect();
        $sub_price = 0;
        $total_price = 0;

        $t_tax = 0;
        $total_tax = 0;

        $grand_total = 0;
        $temp_grand_total = 0;

        if(count(collect($request)->get('carts')) >0){
            foreach ($request->carts as $key => $cart) {
                if($cart['campaign_id'] != null) {
                    $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                    if($campaign->end_at >= Carbon::now()->format('Y-m-d')){
                        $demo_obj = new Demo;
                        $vendorPStock = VendorProductVariantStock::find($cart['vProductVS_id']);
                        $pro = VendorProduct::where('id', $vendorPStock->vendor_product_id)->with('product')->first();
//                        $vendorPStock = VendorProductVariantStock::where('id', $vendorProductVariantStock->id)->first();
                        $demo_obj->id = $key+1;
                        $demo_obj->img = filePath($pro->product->image);
                        $demo_obj->name = $pro->product->name . ' ' . Str::upper($vendorPStock->product_variants);

                        $demo_obj->quantity = $cart['quantity'];
                        $demo_obj->sku = $pro->sku;
                        $demo_obj->slug = $pro->slug;

                        //TODO store variant

                        if ($pro->is_discount == false) {
                            /*check this product in campaign*/
                            if ($cart['campaign_id'] != null) {
                                $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                                $demo_obj->campaign = $campaign->offer;
                                /*todo:cart campaign product calculation*/
                                $after_offer = ($pro->product_price + $vendorPStock->extra_price) -
                                    (($pro->product_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                                $demo_obj->price = formatPrice($after_offer);
                                $demo_obj->blade_quantity_x_price = formatPrice($after_offer*$cart['quantity']);
                                $sub_price += $cart['quantity'] * $after_offer;
                                $t_tax = ($total_tax+ (($pro->product->tax * $sub_price) / 100));
                                $temp_grand_total = $sub_price + $t_tax;
                                $demo_obj->main_price = $pro->product_price + $vendorPStock->extra_price;
                            } else {
                                $demo_obj->price = formatPrice($pro->product_price + $vendorPStock->extra_price);
                                $temp_blade_q_x_p = $pro->product_price + $vendorPStock->extra_price;
                                $demo_obj->blade_quantity_x_price = formatPrice($temp_blade_q_x_p*$cart['quantity']);
                                $sub_price += $cart['quantity'] * ($pro->product_price + $vendorPStock->extra_price) ;
                                $t_tax = $total_tax+ (($pro->product->tax * $sub_price) / 100);
                                $temp_grand_total = $sub_price + $t_tax;

                            }

                        } else {
                            if ($cart['campaign_id'] != null) {
                                $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                                $demo_obj->campaign = $campaign->offer;
                                /*todo:cart campaign product calculation*/
                                $after_offer = ($pro->discount_price + $vendorPStock->extra_price) -
                                    (($pro->discount_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                                $demo_obj->price = formatPrice($after_offer);
                                $demo_obj->blade_quantity_x_price = formatPrice($after_offer*$cart['quantity']);
                                $sub_price += $cart['quantity'] * $after_offer;
                                $t_tax = ($total_tax+ (($pro->product->tax * $sub_price) / 100));
                                $temp_grand_total = $sub_price + $t_tax;
                                $demo_obj->main_price = ($pro->discount_price +$vendorPStock->extra_price);
                            } else {
                                $demo_obj->price = formatPrice($pro->discount_price + $vendorPStock->extra_price);
                                $temp_blade_q_x_p = $pro->discount_price + $vendorPStock->extra_price;
                                $demo_obj->blade_quantity_x_price = formatPrice($temp_blade_q_x_p*$cart['quantity']);
                                $sub_price += $cart['quantity'] * ($pro->discount_price +$vendorPStock->extra_price);
                                $t_tax = $total_tax + (($pro->product->tax * $sub_price) / 100);
                                $temp_grand_total = $sub_price + $t_tax;
                            }
                        }
                        $demo_obj->url = route('single.product',[$pro->product->sku,$pro->product->slug]);

                        $demo_obj->shop_name = Vendor::where('user_id', $pro->user_id)->first()->shop_name;
                        $cart_list->push($demo_obj);
                        $total_price = formatPrice($sub_price);
                    } else{
//                        $cart->delete();
                        //todo:: delete product from cart if campaign is over
                    }
                } else{
                    $demo_obj = new Demo;
                    $vendorPStock = VendorProductVariantStock::find($cart['vProductVS_id']);
                    $pro = VendorProduct::where('id', $vendorPStock->vendor_product_id)->with('product')->first();
//                    $vendorPStock = VendorProductVariantStock::where('id', $vendorProductVariantStock->id)->first();
                    $demo_obj->id = $key+1;
                    $demo_obj->img = filePath($pro->product->image);
                    $demo_obj->name = $pro->product->name . ' ' . Str::upper($vendorPStock->product_variants);

                    $demo_obj->quantity = $cart['quantity'];
                    $demo_obj->sku = $pro->sku;
                    $demo_obj->slug = $pro->slug;

                    //TODO store variant

                    if ($pro->is_discount == false) {
                        /*check this product in campaign*/
                        if ($cart['campaign_id'] != null) {
                            $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                            $demo_obj->campaign = $campaign->offer;
                            /*todo:cart campaign product calculation*/
                            $after_offer = ($pro->product_price + $vendorPStock->extra_price) -
                                (($pro->product_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                            $demo_obj->price = formatPrice($after_offer);
                            $demo_obj->blade_quantity_x_price = formatPrice($after_offer*$cart['quantity']);
                            $sub_price += $cart['quantity'] * $after_offer;
                            $t_tax = ($total_tax+ (($pro->product->tax * $sub_price) / 100));
                            $temp_grand_total = $sub_price + $t_tax;
                            $demo_obj->main_price = $pro->product_price + $vendorPStock->extra_price;
                        } else {
                            $demo_obj->price = formatPrice($pro->product_price + $vendorPStock->extra_price);
                            $temp_blade_q_x_p = $pro->product_price + $vendorPStock->extra_price;
                            $demo_obj->blade_quantity_x_price = formatPrice($temp_blade_q_x_p*$cart['quantity']);
                            $sub_price += $cart['quantity'] * ($pro->product_price + $vendorPStock->extra_price) ;
                            $t_tax = $total_tax + (($pro->product->tax * $sub_price) / 100);
                            $temp_grand_total = $sub_price + $t_tax;
                        }

                    } else {

                        if ($cart['campaign_id'] != null) {
                            $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                            $demo_obj->campaign = $campaign->offer;
                            /*todo:cart campaign product calculation*/
                            $after_offer = ($pro->discount_price + $vendorPStock->extra_price) -
                                (($pro->discount_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                            $demo_obj->price = formatPrice($after_offer);
                            $demo_obj->blade_quantity_x_price = formatPrice($after_offer*$cart['quantity']);
                            $sub_price += $cart['quantity'] * $after_offer;
                            $t_tax = ($total_tax+ (($pro->product->tax * $sub_price) / 100));
                            $temp_grand_total = $sub_price + $t_tax;
                            $demo_obj->main_price = ($pro->discount_price +$vendorPStock->extra_price);
                        } else {
                            $demo_obj->price = formatPrice($pro->discount_price + $vendorPStock->extra_price);
                            $temp_blade_q_x_p = $pro->discount_price + $vendorPStock->extra_price;
                            $demo_obj->blade_quantity_x_price = formatPrice($temp_blade_q_x_p*$cart['quantity']);
                            $sub_price += $cart['quantity'] * ($pro->discount_price +$vendorPStock->extra_price);
                            $t_tax = $total_tax + (($pro->product->tax * $sub_price) / 100);
                            $temp_grand_total = $sub_price + $t_tax;
                        }
                    }
                    $demo_obj->url = route('single.product',[$pro->product->sku,$pro->product->slug]);

                    $demo_obj->shop_name = Vendor::where('user_id', $pro->user_id)->first()->shop_name;
                    $cart_list->push($demo_obj);
                    $total_price = formatPrice($sub_price);
                    $temp_grand_total = $sub_price + $t_tax;
                }

            }
        }
        else{
            $total_price = formatPrice(0);
        }

        $total_tax = formatPrice($t_tax);
        $grand_total = formatPrice($temp_grand_total);

        $is_vendor = true;
        $auth = Auth::check();
        Artisan::call('view:clear');
        return response([$cart_list, $total_price,$total_tax, $grand_total, $is_vendor, $auth]);
    }


    //delete cart item
    public function destroy(Request $request)
    {
        if(Auth::check()){
            $vendorProductVariantStock = VendorProductVariantStock::find($request->delete_item[0]['vProductVS_id']);
            $cart = Cart::where('user_id',Auth::id())
                ->where('vpvs_id', $vendorProductVariantStock->id)
                ->where('vendor_product_id',$vendorProductVariantStock->vendor_product_id)
                ->where('vendor_id',$vendorProductVariantStock->user_id)
                ->first();
            if(!is_null($cart)){
                $cart->forceDelete();
            }
        }
    }

    // shopping_cart
    public function shopping_cart(Request $request)
    {
        return view('frontend.shopping_cart.guestCart');
    }
    // END
}
