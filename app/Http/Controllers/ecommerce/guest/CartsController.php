<?php

namespace App\Http\Controllers\ecommerce\guest;

use App\EcomProductVariantStock;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Demo;
use App\Models\EcomCart;
use App\Models\Product;
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
        $temp_grand_total = 0;

        if(count(collect($request)->get('carts')) >0){
            foreach ($request->carts as $key => $cart) {
                if($cart['campaign_id'] != null) {
                    $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                    if ($campaign->end_at >= Carbon::now()->format('Y-m-d')) {
                        $demo_obj = new Demo;
                        $product_vendor_stock = EcomProductVariantStock::find($cart['vProductVS_id']);
                        $pro = Product::where('id', $product_vendor_stock->product_id)->first();
//                        $product_vendor_stock = EcomProductVariantStock::where('id', $EcomProductVariantStock->id)->first();
                        $demo_obj->id = $key+1;
                        $demo_obj->img = filePath($pro->image);
                        $demo_obj->name = $pro->name . ' ' . Str::upper($product_vendor_stock->product_variants);

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
                                $after_offer = ($pro->product_price + $product_vendor_stock->extra_price) -
                                    (($pro->product_price + $product_vendor_stock->extra_price) * ($campaign->offer / 100));
                                $demo_obj->price = formatPrice($after_offer);
                                $demo_obj->blade_quantity_x_price = formatPrice($after_offer*$cart['quantity']);
                                $price = $cart['quantity'] * $after_offer;
                                $t_tax += (($pro->tax * $price) / 100);
                                $temp_grand_total += ($price + (($pro->tax * $price) / 100));
                                $sub_price += $price;
                                $demo_obj->main_price = $pro->product_price + $product_vendor_stock->extra_price;
                            } else {
                                $demo_obj->price = formatPrice($pro->product_price + $product_vendor_stock->extra_price);

                                $temp_blade_q_x_p = $pro->product_price + $product_vendor_stock->extra_price;
                                $demo_obj->blade_quantity_x_price = formatPrice($temp_blade_q_x_p*$cart['quantity']);

                                $price = ($cart['quantity'] * ($pro->product_price + $product_vendor_stock->extra_price));
                                $sub_price += $price;
                                $t_tax += (($pro->tax * $price) / 100);
                                $temp_grand_total += $price + (($pro->tax * $price) / 100);
                            }

                        } else {

                            if ($cart['campaign_id'] != null) {
                                $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                                $demo_obj->campaign = $campaign->offer;
                                /*todo:cart campaign product calculation*/
                                $after_offer = ($pro->discount_price + $product_vendor_stock->extra_price) -
                                    (($pro->discount_price + $product_vendor_stock->extra_price) * ($campaign->offer / 100));
                                $demo_obj->price = formatPrice($after_offer);
                                $demo_obj->blade_quantity_x_price = formatPrice($after_offer*$cart['quantity']);
                                $price = $cart['quantity'] * $after_offer;
                                $sub_price += $price;
                                $t_tax += (($pro->tax * $price) / 100);
                                $temp_grand_total += $price + (($pro->tax * $price) / 100);
                                $demo_obj->main_price = ($pro->discount_price + $product_vendor_stock->extra_price);
                            } else {
                                $demo_obj->price = formatPrice($pro->discount_price + $product_vendor_stock->extra_price);

                                $temp_blade_q_x_p = $pro->discount_price + $product_vendor_stock->extra_price;
                                $demo_obj->blade_quantity_x_price = formatPrice($temp_blade_q_x_p*$cart['quantity']);
                                $price = ($cart['quantity'] * ($pro->discount_price + $product_vendor_stock->extra_price));
                                $sub_price += $price;
                                $t_tax += (($pro->tax * $price) / 100);
                                $temp_grand_total += $price + (($pro->tax * $price) / 100);
                            }
                        }
                        $demo_obj->url = route('single.product', [$pro->sku, $pro->slug]);

                        $cart_list->push($demo_obj);
                        $total_price = formatPrice($sub_price);
                    } else {
                       $cart->delete();
                    }
                } else {
                    $demo_obj = new Demo;
                    $product_vendor_stock = EcomProductVariantStock::find($cart['vProductVS_id']);
                    $pro = Product::where('id', $product_vendor_stock->product_id)->first();
//                    $product_vendor_stock = EcomProductVariantStock::where('id', $EcomProductVariantStock->id)->first();
                    $demo_obj->id = $key+1;
                    $demo_obj->img = filePath($pro->image);
                    $demo_obj->name = $pro->name . ' ' . Str::upper($product_vendor_stock->product_variants);

                    $demo_obj->quantity = $cart['quantity'];
                    $demo_obj->sku = $pro->sku;
                    $demo_obj->slug = $pro->slug;

               

                    if ($pro->is_discount == false) {
                        /*check this product in campaign*/
                        if ($cart['campaign_id'] != null) {
                            $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                            $demo_obj->campaign = $campaign->offer;
                            /*todo:cart campaign product calculation*/
                            $after_offer = ($pro->product_price + $product_vendor_stock->extra_price) -
                                (($pro->product_price + $product_vendor_stock->extra_price) * ($campaign->offer / 100));
                            $demo_obj->price = formatPrice($after_offer);
                            $demo_obj->blade_quantity_x_price = formatPrice($after_offer*$cart['quantity']);
                            $price = $cart['quantity'] * $after_offer;
                            $sub_price += $price;
                            $t_tax += (($pro->tax * $price) / 100);
                            $temp_grand_total += $price + (($pro->tax * $price) / 100);
                            $demo_obj->main_price = $pro->product_price + $product_vendor_stock->extra_price;
                        } else {
                            $demo_obj->price = formatPrice($pro->product_price + $product_vendor_stock->extra_price);

                            $temp_blade_q_x_p = $pro->product_price + $product_vendor_stock->extra_price;
                            $demo_obj->blade_quantity_x_price = formatPrice($temp_blade_q_x_p*$cart['quantity']);

                            $price = $cart['quantity'] * ($pro->product_price + $product_vendor_stock->extra_price);
                            $sub_price += $price;
                            $t_tax += (($pro->tax * $price) / 100);
                            $temp_grand_total += $price + (($pro->tax * $price) / 100);
                        }
                    } else {
                        if ($cart['campaign_id'] != null) {
                            $campaign = Campaign::where('id', $cart['campaign_id'])->first();
                            $demo_obj->campaign = $campaign->offer;
                            /*todo:cart campaign product calculation*/
                            $after_offer = ($pro->discount_price + $product_vendor_stock->extra_price) -
                                (($pro->discount_price + $product_vendor_stock->extra_price) * ($campaign->offer / 100));
                            $demo_obj->price = formatPrice($after_offer);
                            $demo_obj->blade_quantity_x_price = formatPrice($after_offer*$cart['quantity']);
                            $price = $cart['quantity'] * $after_offer;
                            $sub_price += $price;
                            $t_tax += (($pro->tax * $price) / 100);
                            $temp_grand_total += $price + (($pro->tax * $price) / 100);
                            $demo_obj->main_price = ($pro->discount_price + $product_vendor_stock->extra_price);
                        } else {
                            $demo_obj->price = formatPrice($pro->discount_price + $product_vendor_stock->extra_price);
                            $temp_blade_q_x_p = $pro->discount_price + $product_vendor_stock->extra_price;
                            $demo_obj->blade_quantity_x_price = formatPrice($temp_blade_q_x_p*$cart['quantity']);
                            $price = $cart['quantity'] * ($pro->discount_price + $product_vendor_stock->extra_price);
                            $sub_price += $price;
                            $t_tax += (($pro->tax * $price) / 100);
                            $temp_grand_total += $price + (($pro->tax * $price) / 100);
                        }
                    }
                    $demo_obj->url = route('single.product', [$pro->sku, $pro->slug]);

                    $cart_list->push($demo_obj);
                    $total_price = formatPrice($sub_price);
                    $temp_grand_total = $sub_price + $t_tax;
                }

            }
        } else {
            $total_price = formatPrice(0);
        }

        $total_tax = formatPrice($t_tax);
        $grand_total = formatPrice($temp_grand_total);

        $is_vendor = false;
        $auth = Auth::check();
        Artisan::call('view:clear');
        return response([$cart_list, $total_price, $total_tax, $grand_total, $is_vendor,$auth]);
    }


    //delete cart item
    public function destroy(Request $request)
    {
        if(Auth::check()){
            $ecomProductVariantStock = EcomProductVariantStock::find($request->delete_item[0]['vProductVS_id']);
            $cart = EcomCart::where('user_id',Auth::id())
                ->where('product_stock_id', $ecomProductVariantStock->id)
                ->where('product_id',$ecomProductVariantStock->product_id)
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

}
