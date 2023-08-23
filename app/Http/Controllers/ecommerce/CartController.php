<?php

namespace App\Http\Controllers\ecommerce;

use App\EcomProductVariantStock;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Demo;
use App\Models\District;
use App\Models\EcomCart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    //all cart items
    public function index()
    {

        $carts = EcomCart::where('user_id', Auth::id())->get();
        //modifying cart items to show in cart btn hover
        $cart_list = collect();
        $sub_price = 0;
        $total_price = 0;
        $t_tax = 0;
        $temp_grand_total = 0;

        if ($carts->count() > 0) {
            foreach ($carts as $cart) {
                if ($cart->campaign_id != null) {
                    $campaign = Campaign::where('id', $cart->campaign_id)->first();
                    if ($campaign->end_at >= Carbon::now()->format('Y-m-d')) {
                        $demo_obj = new Demo;
                        $pro = Product::where('id', $cart->product_id)->first();
                        $product_vendor_stock = EcomProductVariantStock::where('id', $cart->product_stock_id)->first();
                        $demo_obj->id = $cart->id;
                        $demo_obj->img = filePath($pro->image);
                        $demo_obj->name = $pro->name . ' ' . Str::upper($product_vendor_stock->product_variants);

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
                                $after_offer = ($pro->product_price + $product_vendor_stock->extra_price) -
                                    (($pro->product_price + $product_vendor_stock->extra_price) * ($campaign->offer / 100));
                                $demo_obj->price = formatPrice($after_offer);
                                $price = $cart->quantity * $after_offer;
                                $t_tax += (($pro->tax * $price) / 100);
                                $temp_grand_total += ($price + (($pro->tax * $price) / 100));
                                $sub_price += $price;
                                $demo_obj->main_price = $pro->product_price + $product_vendor_stock->extra_price;
                            } else {
                                $demo_obj->price = formatPrice($pro->product_price + $product_vendor_stock->extra_price);
                                $price = ($cart->quantity * ($pro->product_price + $product_vendor_stock->extra_price));
                                $sub_price += $price;
                                $t_tax += (($pro->tax * $price) / 100);
                                $temp_grand_total += $price + (($pro->tax * $price) / 100);
                            }

                        } else {

                            if ($cart->campaign_id != null) {
                                $campaign = Campaign::where('id', $cart->campaign_id)->first();
                                $demo_obj->campaign = $campaign->offer;
                                /*todo:cart campaign product calculation*/
                                $after_offer = ($pro->discount_price + $product_vendor_stock->extra_price) -
                                    (($pro->discount_price + $product_vendor_stock->extra_price) * ($campaign->offer / 100));
                                $demo_obj->price = formatPrice($after_offer);
                                $price = $cart->quantity * $after_offer;
                                $sub_price += $price;
                                $t_tax += (($pro->tax * $price) / 100);
                                $temp_grand_total += $price + (($pro->tax * $price) / 100);
                                $demo_obj->main_price = ($pro->discount_price + $product_vendor_stock->extra_price);
                            } else {
                                $demo_obj->price = formatPrice($pro->discount_price + $product_vendor_stock->extra_price);
                                $price = ($cart->quantity * ($pro->discount_price + $product_vendor_stock->extra_price));
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
                    $pro = Product::where('id', $cart->product_id)->first();
                    $product_vendor_stock = EcomProductVariantStock::where('id', $cart->product_stock_id)->first();
                    $demo_obj->id = $cart->id;
                    $demo_obj->img = filePath($pro->image);
                    $demo_obj->name = $pro->name . ' ' . Str::upper($product_vendor_stock->product_variants);

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
                            $after_offer = ($pro->product_price + $product_vendor_stock->extra_price) -
                                (($pro->product_price + $product_vendor_stock->extra_price) * ($campaign->offer / 100));
                            $demo_obj->price = formatPrice($after_offer);
                            $price = $cart->quantity * $after_offer;
                            $sub_price += $price;
                            $t_tax += (($pro->tax * $price) / 100);
                            $temp_grand_total += $price + (($pro->tax * $price) / 100);
                            $demo_obj->main_price = $pro->product_price + $product_vendor_stock->extra_price;
                        } else {
                            $demo_obj->price = formatPrice($pro->product_price + $product_vendor_stock->extra_price);
                            $price = $cart->quantity * ($pro->product_price + $product_vendor_stock->extra_price);
                            $sub_price += $price;
                            $t_tax += (($pro->tax * $price) / 100);
                            $temp_grand_total += $price + (($pro->tax * $price) / 100);
                        }
                    } else {
                        if ($cart->campaign_id != null) {
                            $campaign = Campaign::where('id', $cart->campaign_id)->first();
                            $demo_obj->campaign = $campaign->offer;
                            /*todo:cart campaign product calculation*/
                            $after_offer = ($pro->discount_price + $product_vendor_stock->extra_price) -
                                (($pro->discount_price + $product_vendor_stock->extra_price) * ($campaign->offer / 100));
                            $demo_obj->price = formatPrice($after_offer);
                            $price = $cart->quantity * $after_offer;
                            $sub_price += $price;
                            $t_tax += (($pro->tax * $price) / 100);
                            $temp_grand_total += $price + (($pro->tax * $price) / 100);
                            $demo_obj->main_price = ($pro->discount_price + $product_vendor_stock->extra_price);
                        } else {
                            $demo_obj->price = formatPrice($pro->discount_price + $product_vendor_stock->extra_price);
                            $price = $cart->quantity * ($pro->discount_price + $product_vendor_stock->extra_price);
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

        if (vendorActive()) {
            $is_vendor = true;
        } else {
            $is_vendor = false;
        }
        return response([$cart_list, $total_price, $total_tax, $grand_total, $is_vendor, $carts]);
    }


    //add to cart
    public function store(Request $request)
    {
        /*here vProductVS_id = product_variant_stock*/
        $existing_cart_item = EcomCart::where('user_id', Auth::id())->where('product_stock_id', $request->vProductVS_id)->first();
        if (is_null($existing_cart_item)) {
            //add to cart
            $product_variant_stock = EcomProductVariantStock::find($request->vProductVS_id);
            $cart = new EcomCart;
            $cart->user_id = Auth::id();
            $cart->product_stock_id = $product_variant_stock->id;
            $cart->product_id = $product_variant_stock->product_id;
            $cart->quantity = $request->quantity;
            $cart->campaign_id = $request->campaign_id;
//            $cart->save();
            return response(["message" => translate('Added to cart')]);
        } else {
            /*check this product in com form campaign*/

            if ($request->campaign_id != null) {
                if ($existing_cart_item->campaign_id != $request->campaign_id) {
                    return response(["message" => translate('Product already in cart,If you want to add campaign product, first remove this product form cart')]);
                }
            }

            if ($existing_cart_item->campaign_id != null) {
                if ($existing_cart_item->campaign_id != $request->campaign_id) {
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

        $updated_tax = 0;
        if ($request->has('idDec')) {
            $quantity = EcomCart::where('id', $request->idDec)->first();

            if ($quantity->quantity != 1) {
                $quantity->decrement('quantity');

                $demo_obj = new Demo;
                /*quantity price increment*/
                $pro = Product::where('id', $quantity->product_id)->first();
                $product_vendor_stock = EcomProductVariantStock::where('id', $quantity->product_stock_id)->first();

                //TODO store variant
                if ($pro->is_discount == false) {
                    /*check this product in campaign*/
                    if ($quantity->campaign_id != null) {
                        $campaign = Campaign::where('id', $quantity->campaign_id)->first();
                        $demo_obj->campaign = $campaign->offer;
                        /*todo:cart campaign product calculation*/
                        $after_offer = ($pro->product_price + $product_vendor_stock->extra_price) -
                            (($pro->product_price + $product_vendor_stock->extra_price) * ($campaign->offer / 100));
                        $demo_obj->price = formatPrice($after_offer);
                        $demo_obj->sub_price = $quantity->quantity * $after_offer;
                        //
                        $t_tax = ($updated_tax + (($pro->tax * $demo_obj->sub_price) / 100));

                    } else {
                        $demo_obj->price = formatPrice($pro->product_price + $product_vendor_stock->extra_price);
                        $demo_obj->sub_price = $quantity->quantity * ($pro->product_price + $product_vendor_stock->extra_price);
                        //
                        $t_tax = $updated_tax + (($pro->tax * $demo_obj->sub_price) / 100);

                    }

                } else {

                    if ($quantity->campaign_id != null) {
                        $campaign = Campaign::where('id', $quantity->campaign_id)->first();
                        $demo_obj->campaign = $campaign->offer;
                        /*todo:cart campaign product calculation*/
                        $after_offer = ($pro->discount_price + $product_vendor_stock->extra_price) -
                            (($pro->discount_price + $product_vendor_stock->extra_price) * ($campaign->offer / 100));
                        $demo_obj->price = formatPrice($after_offer);
                        $demo_obj->sub_price = $quantity->quantity * $after_offer;
                        //
                        $t_tax = ($updated_tax + (($pro->tax * $demo_obj->sub_price) / 100));

                    } else {
                        $demo_obj->price = formatPrice($pro->discount_price + $product_vendor_stock->extra_price);
                        $demo_obj->sub_price = $quantity->quantity * ($pro->discount_price + $product_vendor_stock->extra_price);
                        //
                        $t_tax = $updated_tax + (($pro->tax * $demo_obj->sub_price) / 100);
                    }
                }
                $updated_price = $demo_obj->sub_price;
                $updated_tax = $t_tax;
                return response(["message" => translate('Quantity has been decreased'), 'quantity' => $quantity, 'updated_price' => formatPrice($updated_price), 'updated_tax' => formatPrice($updated_tax)]);
            } else {
                return response(["error" => translate('Quantity can not be less than 1')]);
            }
        }

        // increment

        if ($request->has('idInc')) {
            $quantity = EcomCart::where('id', $request->idInc)->first();

            if ($quantity->quantity < $quantity->relation_product_stock->quantity) {
                $quantity->increment('quantity');

                $demo_obj = new Demo;
                /*quantity price increment*/
                $pro = Product::where('id', $quantity->product_id)->first();
                $product_vendor_stock = EcomProductVariantStock::where('id', $quantity->product_stock_id)->first();

                //TODO store variant
                if ($pro->is_discount == false) {
                    /*check this product in campaign*/
                    if ($quantity->campaign_id != null) {
                        $campaign = Campaign::where('id', $quantity->campaign_id)->first();
                        $demo_obj->campaign = $campaign->offer;
                        /*todo:cart campaign product calculation*/
                        $after_offer = ($pro->product_price + $product_vendor_stock->extra_price) -
                            (($pro->product_price + $product_vendor_stock->extra_price) * ($campaign->offer / 100));
                        $demo_obj->price = formatPrice($after_offer);
                        $demo_obj->sub_price = $quantity->quantity * $after_offer;
                        $t_tax = ($updated_tax + (($pro->tax * $demo_obj->sub_price) / 100));

                    } else {
                        $demo_obj->price = formatPrice($pro->product_price + $product_vendor_stock->extra_price);
                        $demo_obj->sub_price = $quantity->quantity * ($pro->product_price + $product_vendor_stock->extra_price);
                        $t_tax = $updated_tax + (($pro->tax * $demo_obj->sub_price) / 100);

                    }

                } else {

                    if ($quantity->campaign_id != null) {
                        $campaign = Campaign::where('id', $quantity->campaign_id)->first();
                        $demo_obj->campaign = $campaign->offer;
                        /*todo:cart campaign product calculation*/
                        $after_offer = ($pro->discount_price + $product_vendor_stock->extra_price) -
                            (($pro->discount_price + $product_vendor_stock->extra_price) * ($campaign->offer / 100));
                        $demo_obj->price = formatPrice($after_offer);
                        $demo_obj->sub_price = $quantity->quantity * $after_offer;
                        $t_tax = ($updated_tax + (($pro->product->tax * $demo_obj->sub_price) / 100));

                    } else {
                        $demo_obj->price = formatPrice($pro->discount_price + $product_vendor_stock->extra_price);
                        $demo_obj->sub_price = $quantity->quantity * ($pro->discount_price + $product_vendor_stock->extra_price);
                        $t_tax = $updated_tax + (($pro->tax * $demo_obj->sub_price) / 100);
                    }
                }

                $updated_price = $demo_obj->sub_price;
                $updated_tax = $t_tax;
                return response(["message" => translate('Quantity has been increased'), 'quantity' => $quantity, 'updated_price' => formatPrice($updated_price), 'updated_tax' => formatPrice($updated_tax)]);

            } else {

                return response(["error" => translate('Quantity cannot increased')]);

            }
        }
    }


    //delete cart item
    public function destroy(Request $request)
    {
        $cart = EcomCart::findOrFail($request->id);
        $cart->forceDelete();
        return response(["message" => translate('Item has been removed')]);
    }

    // shopping_cart
    public function shopping_cart()
    {
        $carts = EcomCart::where('user_id', Auth::id())->get();
        //modifying cart items to show
        $cart_list = collect();

        $t_price = 0;
        $total_price = 0;

        $t_tax = 0;
        $total_tax = 0;
        foreach ($carts as $cart) {
            $demo_obj = new Demo;
            $pro = Product::where('id', $cart->product_id)->first();

            $product_stock = EcomProductVariantStock::where('id', $cart->product_stock_id)->first();
            $demo_obj->id = $cart->id;
            $demo_obj->img = filePath($pro->image);
            $demo_obj->name = $pro->name . ' ' . Str::upper($product_stock->product_variants);
            $demo_obj->stock = $product_stock->quantity;

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
                    $after_offer = ($pro->product_price + $product_stock->extra_price) -
                        (($pro->product_price + $product_stock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price = formatPrice($after_offer);
                    $demo_obj->sub_price = $cart->quantity * $after_offer;
                    $t_price += $cart->quantity * $after_offer;
                    $t_tax = ($total_tax + (($pro->tax * $t_price) / 100));
                    $demo_obj->main_price = $pro->product_price + $product_stock->extra_price;
                } else {
                    $demo_obj->price = formatPrice($pro->product_price + $product_stock->extra_price);
                    $demo_obj->sub_price = $cart->quantity * ($pro->product_price + $product_stock->extra_price);
                    $t_price += $cart->quantity * ($pro->product_price + $product_stock->extra_price);
                    $t_tax = ($total_tax + (($pro->tax * $t_price) / 100));
                }

            } else {
                if ($cart->campaign_id != null) {
                    $campaign = Campaign::where('id', $cart->campaign_id)->first();
                    $demo_obj->campaign = $campaign->offer;
                    /*todo:cart campaign product calculation*/
                    $after_offer = ($pro->discount_price + $product_stock->extra_price) -
                        (($pro->discount_price + $product_stock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price = formatPrice($after_offer);
                    $demo_obj->sub_price = $cart->quantity * $after_offer;
                    $t_price += $cart->quantity * $after_offer; //product total price with quantity
                    $t_tax = ($total_tax + ($total_tax + (($pro->tax * $t_price) / 100)));
                    $demo_obj->main_price = ($pro->discount_price + $product_stock->extra_price);
                } else {
                    $demo_obj->price = formatPrice($pro->discount_price + $product_stock->extra_price);
                    $demo_obj->sub_price = $cart->quantity * ($pro->discount_price + $product_stock->extra_price);
                    $t_price += $cart->quantity * ($pro->discount_price + $product_stock->extra_price);
                    $t_tax = ($total_tax + (($pro->tax * $t_price) / 100));
                }
            }

            $demo_obj->url = route('single.product', [$pro->sku, $pro->slug]);
            $cart_list->push($demo_obj);
        }
        $total_price = formatPrice($t_price);
        $total_tax = formatPrice($t_tax);

        return view('frontend.shopping_cart.index', compact('cart_list', 'total_price', 'total_tax'));
    }


    public function checkout(Request $request)
    {

        $discount = session()->get('coupon')['discount'] ?? 0;
        $total = session()->get('coupon')['total'] ?? 0;

        $newTotal = $total - $discount;

        $districts = District::all();

        $carts = EcomCart::where('user_id', Auth::id())->get();

        //modifying cart items to show
        $cart_list = collect();
        $t_price = 0;


        $t_tax = 0;

        foreach ($carts as $cart) {
            $demo_obj = new Demo;
            $pro = Product::where('id', $cart->product_id)->first();
            $product_stock = EcomProductVariantStock::where('id', $cart->product_stock_id)->first();
            $demo_obj->id = $cart->id;
            $demo_obj->img = filePath($pro->image);
            $demo_obj->name = $pro->name . ' ' . Str::upper($product_stock->product_variants);
            $demo_obj->product_id = $cart->product_id;
            $demo_obj->product_stock_id = $product_stock->id;
            $demo_obj->sku = $pro->sku;
            $demo_obj->stock = $product_stock->quantity;

            $demo_obj->quantity = $cart->quantity;
            if ($pro->is_discount == false) {
                /*check this product in campaign*/
                if ($cart->campaign_id != null) {
                    $campaign = Campaign::where('id', $cart->campaign_id)->first();
                    $demo_obj->campaign = $campaign->offer;
                    /*todo:cart campaign product calculation*/
                    $after_offer = ($pro->product_price + $product_stock->extra_price) -
                        (($pro->product_price + $product_stock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price = formatPrice($after_offer);
                    $demo_obj->sub_price = $cart->quantity * $after_offer;
                    $t_price += $demo_obj->sub_price;
                    $t_tax += (($pro->tax * $demo_obj->sub_price) / 100);
                    $demo_obj->main_price = $pro->product_price + $product_stock->extra_price;
                } else {
                    $demo_obj->price = formatPrice($pro->product_price + $product_stock->extra_price);
                    $demo_obj->sub_price = $cart->quantity * ($pro->product_price + $product_stock->extra_price);
                    $t_price += $demo_obj->sub_price;
                    $t_tax += (($pro->tax * $demo_obj->sub_price) / 100);
                }

            } else {

                if ($cart->campaign_id != null) {
                    $campaign = Campaign::where('id', $cart->campaign_id)->first();
                    $demo_obj->campaign = $campaign->offer;
                    /*todo:cart campaign product calculation*/
                    $after_offer = ($pro->discount_price + $product_stock->extra_price) -
                        (($pro->discount_price + $product_stock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price = formatPrice($after_offer);
                    $demo_obj->sub_price = $cart->quantity * $after_offer;
                    $t_price += $demo_obj->sub_price;
                    $t_tax += (($pro->tax * $demo_obj->sub_price) / 100);
                    $demo_obj->main_price = ($pro->discount_price + $product_stock->extra_price);
                } else {
                    $demo_obj->price = formatPrice($pro->discount_price + $product_stock->extra_price);
                    $demo_obj->sub_price = $cart->quantity * ($pro->discount_price + $product_stock->extra_price);
                    $t_price += $demo_obj->sub_price;
                    $t_tax += (($pro->tax * $demo_obj->sub_price) / 100);
                }
            }

            $demo_obj->url = route('single.product', [$pro->sku, $pro->slug]);
            $cart_list->push($demo_obj);
        }
        $total_price = $t_price;
        $total_tax = $t_tax;

        return view('frontend.checkout.ecom_index', compact('discount', 'newTotal', 'districts', 'total_price', 'cart_list', 'total_tax'));
    }
}
