<?php

namespace App\Http\Controllers\frontend\customer;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Cart;
use App\Models\Complain;
use App\Models\Demo;
use App\Models\Product;
use App\Models\VendorProductVariantStock;
use App\Vendor;
use App\VendorProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartsController extends Controller
{
    //all cart items
    public function index()
    {

        $carts = Cart::where('user_id', Auth::id())->get();
        //modifying cart items to show in cart btn hover
        $cart_list = collect();
        $sub_price = 0;
        $total_price = 0;

        $t_tax = 0;
        $total_tax = 0;

        $grand_total = 0;
        $temp_grand_total = 0;

        if($carts->count()>0){
            foreach ($carts as $cart) {
                if($cart->campaign_id != null) {
                    $campaign = Campaign::where('id', $cart->campaign_id)->first();
                    if($campaign->end_at >= Carbon::now()->format('Y-m-d')){
                        $demo_obj = new Demo;
                        $pro = VendorProduct::where('id', $cart->vendor_product_id)->with('product')->first();
                        $vendorPStock = VendorProductVariantStock::where('id', $cart->vpvs_id)->first();
                        $demo_obj->id = $cart->product_id;
                        $demo_obj->img = filePath($pro->product->image);
                        $demo_obj->name = $pro->product->name . ' ' . Str::upper($vendorPStock->product_variants);

                        $demo_obj->quantity = $cart->quantity;
                        $demo_obj->sku = $pro->sku;
                        $demo_obj->slug = $pro->slug;

                        //TODO store variant

                        if ($pro->is_discount == false) {
                            /*check this product in campaign*/
                            if ($cart->campaign_id != null) {
                                $campaign = Campaign::where('id', $cart->campaign_id)->first();
                                $demo_obj->campaign = $campaign->offer;
                                /*todo:cart campaign product calculation*/
                                $after_offer = ($pro->product_price + $vendorPStock->extra_price) -
                                    (($pro->product_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                                $demo_obj->price = formatPrice($after_offer);
                                $demo_obj->blade_quantity_x_price = formatPrice($after_offer*$cart->quantity);
                                $sub_price += $cart->quantity * $after_offer;
                                $t_tax = ($total_tax+ (($pro->product->tax * $sub_price) / 100));
                                $temp_grand_total = $sub_price + $t_tax;
                                $demo_obj->main_price = $pro->product_price + $vendorPStock->extra_price;
                            } else {
                                $demo_obj->price = formatPrice($pro->product_price + $vendorPStock->extra_price);
                                $temp_blade_q_x_p = $pro->product_price + $vendorPStock->extra_price;
                                $demo_obj->blade_quantity_x_price = formatPrice($temp_blade_q_x_p*$cart->quantity);
                                $sub_price += $cart->quantity * ($pro->product_price + $vendorPStock->extra_price) ;
                                $t_tax = $total_tax+ (($pro->product->tax * $sub_price) / 100);
                                $temp_grand_total = $sub_price + $t_tax;
                            }

                        } else {

                            if ($cart->campaign_id != null) {
                                $campaign = Campaign::where('id', $cart->campaign_id)->first();
                                $demo_obj->campaign = $campaign->offer;
                                /*todo:cart campaign product calculation*/
                                $after_offer = ($pro->discount_price + $vendorPStock->extra_price) -
                                    (($pro->discount_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                                $demo_obj->price = formatPrice($after_offer);
                                $sub_price += $cart->quantity * $after_offer;
                                $demo_obj->blade_quantity_x_price = formatPrice($after_offer*$cart->quantity);
                                $t_tax = ($total_tax+ (($pro->product->tax * $sub_price) / 100));
                                $temp_grand_total = $sub_price + $t_tax;
                                $demo_obj->main_price = ($pro->discount_price +$vendorPStock->extra_price);
                            } else {
                                $demo_obj->price = formatPrice($pro->discount_price + $vendorPStock->extra_price);
                                $temp_blade_q_x_p = $pro->discount_price + $vendorPStock->extra_price;
                                $demo_obj->blade_quantity_x_price = formatPrice($temp_blade_q_x_p*$cart->quantity);
                                $sub_price += $cart->quantity * ($pro->discount_price +$vendorPStock->extra_price);
                                $t_tax = $total_tax + (($pro->product->tax * $sub_price) / 100);
                                $temp_grand_total = $sub_price + $t_tax;
                            }
                        }
                        $demo_obj->url = route('single.product',[$pro->product->sku,$pro->product->slug]);

                        $demo_obj->shop_name = Vendor::where('user_id', $pro->user_id)->first()->shop_name;
                        $cart_list->push($demo_obj);
                        $total_price = formatPrice($sub_price);
                    } else{
                        $cart->delete();
                    }
                } else{
                    $demo_obj = new Demo;
                    $pro = VendorProduct::where('id', $cart->vendor_product_id)->with('product')->first();
                    $vendorPStock = VendorProductVariantStock::where('id', $cart->vpvs_id)->first();
                    $demo_obj->id = $cart->id;
                    $demo_obj->img = filePath($pro->product->image);
                    $demo_obj->name = $pro->product->name . ' ' . Str::upper($vendorPStock->product_variants);

                    $demo_obj->quantity = $cart->quantity;
                    $demo_obj->sku = $pro->sku;
                    $demo_obj->slug = $pro->slug;

                    //TODO store variant

                    if ($pro->is_discount == false) {
                        /*check this product in campaign*/
                        if ($cart->campaign_id != null) {
                            $campaign = Campaign::where('id', $cart->campaign_id)->first();
                            $demo_obj->campaign = $campaign->offer;
                            /*todo:cart campaign product calculation*/
                            $after_offer = ($pro->product_price + $vendorPStock->extra_price) -
                                (($pro->product_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                            $demo_obj->price = formatPrice($after_offer);
                            $sub_price += $cart->quantity * $after_offer;
                            $demo_obj->blade_quantity_x_price = formatPrice($after_offer*$cart->quantity);
                            $t_tax = ($total_tax+ (($pro->product->tax * $sub_price) / 100));
                            $temp_grand_total = $sub_price + $t_tax;
                            $demo_obj->main_price = $pro->product_price + $vendorPStock->extra_price;
                        } else {
                            $demo_obj->price = formatPrice($pro->product_price + $vendorPStock->extra_price);
                            $temp_blade_q_x_p = $pro->product_price + $vendorPStock->extra_price;
                            $demo_obj->blade_quantity_x_price = formatPrice($temp_blade_q_x_p*$cart->quantity);
                            $sub_price += $cart->quantity * ($pro->product_price + $vendorPStock->extra_price) ;
                            $t_tax = $total_tax + (($pro->product->tax * $sub_price) / 100);
                            $temp_grand_total = $sub_price + $t_tax;
                        }

                    } else {

                        if ($cart->campaign_id != null) {
                            $campaign = Campaign::where('id', $cart->campaign_id)->first();
                            $demo_obj->campaign = $campaign->offer;
                            /*todo:cart campaign product calculation*/
                            $after_offer = ($pro->discount_price + $vendorPStock->extra_price) -
                                (($pro->discount_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                            $demo_obj->price = formatPrice($after_offer);
                            $demo_obj->blade_quantity_x_price = formatPrice($after_offer*$cart->quantity);
                            $sub_price += $cart->quantity * $after_offer;
                            $t_tax = ($total_tax+ (($pro->product->tax * $sub_price) / 100));
                            $temp_grand_total = $sub_price + $t_tax;
                            $demo_obj->main_price = ($pro->discount_price +$vendorPStock->extra_price);
                        } else {
                            $demo_obj->price = formatPrice($pro->discount_price + $vendorPStock->extra_price);
                            $temp_blade_q_x_p = $pro->discount_price + $vendorPStock->extra_price;
                            $demo_obj->blade_quantity_x_price = formatPrice($temp_blade_q_x_p*$cart->quantity);
                            $sub_price += $cart->quantity * ($pro->discount_price +$vendorPStock->extra_price);
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

        if (vendorActive()) {
            $is_vendor = true;
        } else {
            $is_vendor = false;
        }

        return response([$cart_list, $total_price,$total_tax, $grand_total, $is_vendor, $carts]);
    }


    //add to cart
    public function store(Request $request)
    {

        $existing_cart_item = Cart::where('user_id', Auth::id())->where('vpvs_id', $request->vProductVS_id)->first();
        if (is_null($existing_cart_item)) {
            //add to cart
            $vendorProductVariantStock = VendorProductVariantStock::find($request->vProductVS_id);
            $cart = new Cart;
            $cart->user_id = Auth::id();
            $cart->vendor_product_id = $vendorProductVariantStock->vendor_product_id;
            $cart->vpvs_id = $vendorProductVariantStock->id;
            $cart->vendor_id = Vendor::where('user_id', $vendorProductVariantStock->user_id)->first()->id;
            $cart->quantity = $request->quantity;
            $cart->campaign_id = $request->campaign_id;
//            $cart->save();
            return response(["message" => translate('Added to cart')]);
        } else {
            /*check this product in com form campaign*/

            if($request->campaign_id != null ){
                if($existing_cart_item->campaign_id != $request->campaign_id){
                    return response(["message" => translate('Product already in cart,If you want to add campaign product, first remove this product form cart')]);
                }
            }

            if ($existing_cart_item->campaign_id != null){
                if($existing_cart_item->campaign_id != $request->campaign_id){
                    return response(["message" => translate('Product already in cart,If you want to add this product, first remove this product form cart')]);
                }
            }
            $existing_cart_item->quantity = $existing_cart_item->quantity + 1;
//            $existing_cart_item->save();
            return response(["message" => translate('Quantity has been increased')]);
        }
    }


    //TODO update cart quantity here
    /**
     * Cart Update
     */
    public function update(Request $request)
    {

        $updated_price = 0;

        $t_tax = 0;
        $updated_tax = 0;

        // decrement

        if($request->has('idDec')){
            $quantity = Cart::where('id', $request->idDec)->first();

            if($quantity->quantity != 1){
                $quantity->decrement('quantity');

                $demo_obj = new Demo;
                /*quantity price increment*/
                $pro = VendorProduct::where('id', $quantity->vendor_product_id)->with('product')->first();
                $vendorPStock = VendorProductVariantStock::where('id', $quantity->vpvs_id)->first();

                //TODO store variant
                if ($pro->is_discount == false) {
                    /*check this product in campaign*/
                    if ($quantity->campaign_id != null) {
                        $campaign = Campaign::where('id', $quantity->campaign_id)->first();
                        $demo_obj->campaign = $campaign->offer;
                        /*todo:cart campaign product calculation*/
                        $after_offer = ($pro->product_price + $vendorPStock->extra_price) -
                            (($pro->product_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                        $demo_obj->price = formatPrice($after_offer);
                        $demo_obj->sub_price = $quantity->quantity * $after_offer;
                        $t_tax = ($updated_tax+ (($pro->product->tax * $demo_obj->sub_price) / 100));

                    } else {
                        $demo_obj->price = formatPrice($pro->product_price + $vendorPStock->extra_price);
                        $demo_obj->sub_price = $quantity->quantity * ($pro->product_price + $vendorPStock->extra_price);
                        $t_tax = $updated_tax+ (($pro->product->tax * $demo_obj->sub_price) / 100);

                    }

                } else {

                    if ($quantity->campaign_id != null) {
                        $campaign = Campaign::where('id', $quantity->campaign_id)->first();
                        $demo_obj->campaign = $campaign->offer;
                        /*todo:cart campaign product calculation*/
                        $after_offer = ($pro->discount_price + $vendorPStock->extra_price) -
                            (($pro->discount_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                        $demo_obj->price = formatPrice($after_offer);
                        $demo_obj->sub_price = $quantity->quantity * $after_offer;
                        $t_tax = ($updated_tax+ (($pro->product->tax * $demo_obj->sub_price) / 100));

                    } else {
                        $demo_obj->price = formatPrice($pro->discount_price + $vendorPStock->extra_price);
                        $demo_obj->sub_price = $quantity->quantity * ($pro->discount_price +$vendorPStock->extra_price);
                        $t_tax = $updated_tax+ (($pro->product->tax * $demo_obj->sub_price) / 100);
                    }
                }
                $updated_price = $demo_obj->sub_price;
                $updated_tax = $t_tax;
                return response(["message" => translate('Quantity has been decresed'),'quantity'=> $quantity,'updated_price' => formatPrice($updated_price),'updated_tax' => formatPrice($updated_tax)  ]);
            }else{
                return response(["error" => translate('Quantity atleast 1 needed')]);
            }
        }

        // increment

        if($request->has('idInc')){
            $quantity = Cart::where('id', $request->idInc)->first();

            if($quantity->quantity < $quantity->relationBetweenVariantProductStock->quantity){
                $quantity->increment('quantity');

                $demo_obj = new Demo;
                /*quantity price increment*/
                $pro = VendorProduct::where('id', $quantity->vendor_product_id)->with('product')->first();
                $vendorPStock = VendorProductVariantStock::where('id', $quantity->vpvs_id)->first();

                //TODO store variant
                if ($pro->is_discount == false) {
                    /*check this product in campaign*/
                    if ($quantity->campaign_id != null) {
                        $campaign = Campaign::where('id', $quantity->campaign_id)->first();
                        $demo_obj->campaign = $campaign->offer;
                        /*todo:cart campaign product calculation*/
                        $after_offer = ($pro->product_price + $vendorPStock->extra_price) -
                            (($pro->product_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                        $demo_obj->price = formatPrice($after_offer);
                        $demo_obj->sub_price = $quantity->quantity * $after_offer;
                        $t_tax = ($updated_tax+ (($pro->product->tax * $demo_obj->sub_price) / 100));

                    } else {
                        $demo_obj->price = formatPrice($pro->product_price + $vendorPStock->extra_price);
                        $demo_obj->sub_price = $quantity->quantity * ($pro->product_price + $vendorPStock->extra_price);
                        $t_tax = $updated_tax+ (($pro->product->tax * $demo_obj->sub_price) / 100);

                    }

                } else {

                    if ($quantity->campaign_id != null) {
                        $campaign = Campaign::where('id', $quantity->campaign_id)->first();
                        $demo_obj->campaign = $campaign->offer;
                        /*todo:cart campaign product calculation*/
                        $after_offer = ($pro->discount_price + $vendorPStock->extra_price) -
                            (($pro->discount_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                        $demo_obj->price = formatPrice($after_offer);
                        $demo_obj->sub_price = $quantity->quantity * $after_offer;
                        $t_tax = ($updated_tax+ (($pro->product->tax * $demo_obj->sub_price) / 100));

                    } else {
                        $demo_obj->price = formatPrice($pro->discount_price + $vendorPStock->extra_price);
                        $demo_obj->sub_price = $quantity->quantity * ($pro->discount_price +$vendorPStock->extra_price);
                        $t_tax = $updated_tax+ (($pro->product->tax * $demo_obj->sub_price) / 100);
                    }
                }

                $updated_price = $demo_obj->sub_price;
                $updated_tax = $t_tax;
                return response(["message" => translate('Quantity has been increased'),'quantity'=>$quantity,'updated_price' => formatPrice($updated_price),'updated_tax' => formatPrice($updated_tax) ]);

            }else{

                return response(["error" => translate('Quantity cannot increased')]);

            }
        }
    }


    //delete cart item
    public function destroy(Request $request)
    {
        $cart = Cart::findOrFail($request->id);
        $cart->forceDelete();
        return response(["message" => translate('Item has been removed')]);
    }

    // shopping_cart
    public function shopping_cart()
    {
        $carts = Cart::where('user_id', Auth::id())->get();
        //modifying cart items to show
        $cart_list = collect();

        $t_price = 0;
        $total_price = 0;

        $t_tax = 0;
        $total_tax = 0;
        foreach ($carts as $cart) {
            $demo_obj = new Demo;
            $pro = VendorProduct::where('id', $cart->vendor_product_id)->with('product')->first();
            $vendorPStock = VendorProductVariantStock::where('id', $cart->vpvs_id)->first();
            $demo_obj->id = $cart->id;
            $demo_obj->img = filePath($pro->product->image);
            $demo_obj->name = $pro->product->name . ' ' . Str::upper($vendorPStock->product_variants);
            $demo_obj->stock = $vendorPStock->quantity;

            $demo_obj->quantity = $cart->quantity;
            $demo_obj->sku = $pro->sku;
            $demo_obj->slug = $pro->slug;

            //TODO store variant
            if ($pro->is_discount == false) {
                /*check this product in campaign*/
                if ($cart->campaign_id != null) {
                    $campaign = Campaign::where('id', $cart->campaign_id)->first();
                    $demo_obj->campaign = $campaign->offer;
                    /*todo:cart campaign product calculation*/
                    $after_offer = ($pro->product_price + $vendorPStock->extra_price) -
                        (($pro->product_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price = formatPrice($after_offer);
                    $demo_obj->sub_price = $cart->quantity * $after_offer;
                    $t_price += $cart->quantity * $after_offer;
                    $t_tax = ($total_tax+ (($pro->product->tax * $t_price) / 100));
                    $demo_obj->main_price = $pro->product_price + $vendorPStock->extra_price;
                } else {
                    $demo_obj->price = formatPrice($pro->product_price + $vendorPStock->extra_price);
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
                    $demo_obj->price = formatPrice($after_offer);
                    $demo_obj->sub_price = $cart->quantity * $after_offer;
                    $t_price += $cart->quantity * $after_offer; //product total price with quantity
                    $t_tax = ($total_tax+ ($total_tax+ (($pro->product->tax * $t_price) / 100)));
                    $demo_obj->main_price = ($pro->discount_price +$vendorPStock->extra_price);
                } else {
                    $demo_obj->price = formatPrice($pro->discount_price + $vendorPStock->extra_price);
                    $demo_obj->sub_price = $cart->quantity * ($pro->discount_price +$vendorPStock->extra_price);
                    $t_price += $cart->quantity * ($pro->discount_price +$vendorPStock->extra_price);
                    $t_tax = ($total_tax+ (($pro->product->tax * $t_price) / 100));
                }
            }

            $demo_obj->url = route('single.product',[$pro->product->sku,$pro->product->slug]);
            $demo_obj->shop_name = Vendor::where('user_id', $pro->user_id)->first()->shop_name;
            $cart_list->push($demo_obj);
        }
        $total_price = formatPrice($t_price);
        $total_tax = formatPrice($t_tax);
        return view('frontend.shopping_cart.index', compact('cart_list', 'total_price', 'total_tax'));
    }
    // END
}
