<?php

namespace App\Http\Controllers\api;
use App\EcomProductVariantStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\EcommCampaignResource;
use App\Http\Resources\EcommerceOrderResource;
use App\Http\Resources\EcommerceSingleProduct;
use App\Http\Resources\ShopCartResource;
use App\Http\Resources\VendorProductResource;
use App\Mail\InvoiceMail;
use App\Models\Brand;
use App\Models\Campaign;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Demo;
use App\Models\EcomCampaignProduct;
use App\Models\EcomOrder;
use App\Models\EcomOrderProduct;
use App\Models\LogisticArea;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Variant;
use App\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EcommerceController extends Controller
{
    //show
    public function trendingProducts()
    {
        $products = collect();
        foreach (subCategory() as $subCat) {
            $b_value = 0;
            foreach ($subCat->products as $product) {
                $b_value++;
                $demo = new Demo();
                $demo->product_id = $product->id;
                $demo->sku = $product->sku;
                $demo->slug = $product->slug;
                $demo->image = filePath($product->image);
                $demo->name = $product->name;
                $demo->discount = formatPrice($product->discount_price);
                if ($demo->discount == formatPrice(0)) {
                    $demo->discountHave = false;
                } else {
                    $demo->discountHave = true;
                }
                $demo->price = formatPrice($product->product_price);
                $products->push($demo);

                if ($b_value == 2) {
                    break;
                }
            }
        }
        /*this is work for ecommerce trending Product */
        return VendorProductResource::collection($products);
    }

    /*brand product*/
    public function brand_product($slug)
    {
        $brand_products = Brand::where('id', $slug)->Published()->with('products')->first(); //paginate(16);
        $vendor_product = collect();
        foreach ($brand_products->products as $pro) {
            $demo = new Demo();
            $demo->product_id = $pro->id;
            $demo->sku = $pro->sku;
            $demo->slug = $pro->slug;
            $demo->name = $pro->name;
            $demo->image = filePath($pro->image);
            $demo->discount = formatPrice($pro->discount_price);
            if ($demo->discount == formatPrice(0)) {
                $demo->discountHave = false;
            } else {
                $demo->discountHave = true;
            }
            $demo->price = formatPrice($pro->product_price);
            $vendor_product->push($demo);

        }
        return VendorProductResource::collection($vendor_product);

    }


    /*category product*/
    public function get_cat_product($id)
    {
        $products = collect();
        $cat = Category::where('id', $id)->Published()->with('childrenCategories')->first();
        if ($cat->childrenCategories->count() > 0) {
            $parent_slug = $cat->slug;
            $category_products = Category::where('id', $id)->Published()->with('frontCategoryProducts')->first();
            foreach ($category_products->frontCategoryProducts as $pro) {
                $demo = new Demo();
                $demo->product_id = $pro->id;
                $demo->sku = $pro->sku;
                $demo->slug = $pro->slug;
                $demo->name = $pro->name;
                $demo->image = filePath($pro->image);
                $demo->discount = formatPrice($pro->discount_price);
                if ($demo->discount == formatPrice(0)) {
                    $demo->discountHave = false;
                } else {
                    $demo->discountHave = true;
                }
                $demo->price = formatPrice($pro->product_price);
                $products->push($demo);
            }
        } else {
            $category_products = Category::where('id', $id)->Published()->with('subCategoryProducts')->first();
            foreach ($category_products->subCategoryProducts as $pro) {
                $demo = new Demo();
                $demo->product_id = $pro->id;
                $demo->sku = $pro->sku;
                $demo->slug = $pro->slug;
                $demo->name = $pro->name;
                $demo->image = filePath($pro->image);
                $demo->discount = formatPrice($pro->discount_price);
                if ($demo->discount == formatPrice(0)) {
                    $demo->discountHave = false;
                } else {
                    $demo->discountHave = true;
                }
                $demo->price = formatPrice($pro->product_price);
                $products->push($demo);
            }
        }
        return VendorProductResource::collection($products);
    }

    /*wishlist*/
    public function wishlist(Request $request)
    {
        $datas = json_decode($request->wishlists);
        $vendor_product = collect();
        foreach ($datas as $p) {
            $pro = Product::Published()->where('id', $p)->first();
            if ($pro != null) {
                $demo = new Demo();
                $demo->product_id = $pro->id;
                $demo->sku = $pro->sku;
                $demo->slug = $pro->slug;
                $demo->name = $pro->name;
                $demo->image = filePath($pro->image);
                $demo->discount = formatPrice($pro->discount_price);
                if ($demo->discount == formatPrice(0)) {
                    $demo->discountHave = false;
                } else {
                    $demo->discountHave = true;
                }
                $demo->price = formatPrice($pro->product_price);
                $vendor_product->push($demo);
            }
        }
        return VendorProductResource::collection($vendor_product);
    }


    /*campaign product*/
    public function campaign_product($id)
    {
        $product_list = collect();
        $vpvs_id = 0;
        $stockOut = false;
        $campaign = Campaign::where('id', $id)->On()->first();
        if ($campaign != null) {
            /*campaign product relation*/
            $products = EcomCampaignProduct::where('campaign_id', $campaign->id)->with('product')->get();
            //modifying product items to show in campaign products list
            foreach ($products as $pro) {
                /*campaign product*/
                if ($pro->product != null) {
                    $demo_obj = new Demo();
                    $demo_obj->product_id = $pro->product->id;
                    $demo_obj->image = filePath($pro->product->image);
                    $demo_obj->name = $pro->product->name;
                    $demo_obj->campaign_id = $campaign->id;
                    $demo_obj->quantity = $pro->quantity;
                    if (!$pro->product->have_variant) {
                        $vpvs = EcomProductVariantStock::where('product_id', $pro->product->id)->first();
                        /*here the add product in list*/
                        $stockOut = $vpvs->quantity <= 1 ? true : false;
                        $vpvs_id = $vpvs->id;
                    } else {
                        $variants = collect();
                        $stock = EcomProductVariantStock::where('product_id', $pro->product->id)->with('product')->get();

                        foreach ($stock as $variant) {

                            $option = new Vendor();
                            /*here the design in frontend*/
                            $option->stockOut = $variant->quantity <= 1 ? true : false;
                            if ($variant->product->is_discount > 0) {
                                $price = $variant->product->discount_price;
                                $option->discountText = translate('Discount ') . number_format($variant->product->discount_percentage - 100) . '%';
                            } else {
                                $option->discountText = translate('No discount available');
                                $price = $variant->product->product_price;
                            }
                            $option->priceFormat = formatPrice($price);
                            $option->price = $price;
                            $option->extraPriceFormat = translate('Extra Price ') . formatPrice($variant->extra_price);
                            $option->extraPrice = $variant->extra_price;
                            $option->totalPriceFormat = formatPrice($price + $variant->extra_price);
                            $option->totalPrice = $price + $variant->extra_price;
                            $option->stockId = $variant->id;
                            $option->variant = Str::upper($variant->product_variants);
                            $variants->push($option);
                        }
                    }
                    $demo_obj->stockOut = $stockOut;
                    $demo_obj->variants = $variants;
                    $demo_obj->variant_stock_id = $vpvs_id;

                    //TODO take variant boolean, price of product reducing campaign offer %
                    if ($pro->product->is_discount == false) {
                        $demo_obj->price = formatPrice($pro->product->product_price);
                    } else {
                        $demo_obj->price = formatPrice($pro->product->discount_price);
                    }
                    $product_list->push($demo_obj);
                }

            }
        }
        return EcommCampaignResource::collection($product_list);
    }

    /*search product*/
    public function search_product($name)
    {
        if ($name == 'all') {
            $products = Product::Published()->get()->shuffle()->take(20);
        } else {
            $products = Product::Published()->where('name', 'LIKE', '%' . $name . '%')->get()->take(20);
        }

        $search_products = collect();
        foreach ($products as $pro) {
            $demo = new Demo();
            $demo->product_id = $pro->id;
            $demo->sku = $pro->sku;
            $demo->slug = $pro->slug;
            $demo->name = $pro->name;
            if ($pro->image == null) {
                $demo->image = filePath('comparison.png');
            } else {
                $demo->image = filePath($pro->image);
            }
            $demo->discount = formatPrice($pro->discount_price);
            if ($demo->discount == formatPrice(0)) {
                $demo->discountHave = false;
            } else {
                $demo->discountHave = true;
            }
            $demo->price = formatPrice($pro->product_price);
            $search_products->push($demo);
        }
        return VendorProductResource::collection($search_products);
    }
    /*there are some issue*/

    /*show single product*/
    public function single_product($id)
    {


        $single_product = Product::where('id', $id)
            ->with('images')
            ->with('brand')
            ->with('category')
            ->with('childcategory')
            ->with('variants')
            ->first();

        /*get product variant data*/
        $product_variants = collect();
        $units_array = array();
        if ($single_product->variants->count() > 0) {
            $v_id = array();
            foreach ($single_product->variants as $vid) {
                array_push($v_id, $vid->variant_id);
            }
            $product_variants = Variant::whereIn('id', $v_id)->get();


            /*for variant unit/ type this data for javascript*/
            $units_array = array();
            $unit = null;
            foreach ($product_variants as $vid) {
                if ($unit == null || $unit = !$vid->unit) {
                    $unit = $vid->unit;
                    array_push($units_array, $vid->unit);
                }
            }
            $units_array = array_unique($units_array);
        }


        /*here the create products collection*/

        $demo = new Demo();
        $demo->productId = $single_product->id;
        $demo->name = $single_product->name;
        $demo->bigDesc = $single_product->mobile_desc;
        $demo->discount = formatPrice($single_product->discount_price);
        if ($demo->discount == formatPrice(0)) {
            $demo->discountHave = false;
        } else {
            $demo->discountHave = true;
        }

        $demo->price = formatPrice($single_product->product_price);

        /*image collection*/
        $images = collect();
        $img = new Brand();
        $img->url = filePath($single_product->image);
        $images->push($img);
        foreach ($single_product->images as $img) {
            $im = new Brand();
            $im->url = filePath($img->image);
            $images->push($im);
        }
        /*append it in images*/
        $demo->images = $images;
        /*category*/
        $demo->catName = $single_product->childcategory->name;
        $demo->catId = $single_product->childcategory->id;
        /*brand*/
        $demo->brand = $single_product->brand->name;
        $demo->brandId = $single_product->brand->id;


        /*variant add*/
        $variants = collect();
        foreach ($units_array as $unit) {
            $ns = new Demo();
            $ns->unit = $unit;

            /*get variant by unit*/
            $variant = collect();
            foreach ($product_variants->where('unit', $unit) as $vs) {

                $v = new Variant();
                $v->variantId = $vs->id;
                $v->unit = $vs->unit;
                $v->variant = $vs->variant;
                $v->code = $vs->code;
                $variant->push($v);
            }
            $ns->variant = $variant;
            $variants->push($ns);
        }

        $demo->variants = $variants;
        if ($demo->variants->count() <= 0) {
            $vstock = EcomProductVariantStock::where('product_id', $single_product->id)
                ->Published()
                ->Active()
                ->first();
            $demo->productStockId = $vstock->id;
        } else {
            $demo->productStockId = 0;
        }
        return new EcommerceSingleProduct($demo);
    }

    /*variant by stock*/
    public function variant_by_stock($variant, $productId)
    {

        $free_delivery = translate('Free Delivery');
        $product = Product::where('id', $productId)->first();
        if ($variant != null) {
            $datas = explode("-", $variant);

            $product_variant = ProductVariant::whereIn('variant_id', $datas)->where('product_id', $productId)->get();

            $id = "";
            foreach ($product_variant as $vc) {
                $id .= $vc->id . '-';
            }


            /*this string for like match in vendor product variant stock table*/
            $string = substr($id, 0, -1);
            /*get table data*/
            /*todo:next update we change it*/

            $productVariantStock = EcomProductVariantStock::where('product_variants_id', 'LIKE', '%' . $string . '%')
                ->where('product_id', $productId)
                ->Published()
                ->Active()
                ->first();

        } else {
            $productVariantStock = EcomProductVariantStock::where('product_id', $productId)
                ->Published()
                ->Active()
                ->first();
        }

        $demo = new Demo();
        /*create demo ecommerce product details*/
        if ($productVariantStock != null && $product != null) {
            $demo->productHave = true;
            /*here the design in frontend*/
            $demo->stock_out = $productVariantStock->quantity <= 1 ? 'out_of_stock' : null;
            if ($demo->stock_out == 'out_of_stock') {
                $demo->stock_out = 'Out Of Stock';
                $demo->stock = false;
            } else {
                $demo->stock = true;
                $demo->stock_out = 'Add To Cart ';
            }
            $price = 0;
            if ($product->is_discount > 0) {
                $price = $product->discount_price;
            } else {
                $price = $product->product_price;
            }
            $demo->totalPriceFormat = formatPrice($price + $productVariantStock->extra_price);
            $demo->productStockId = $productVariantStock->id;

        } else {
            $demo->productHave = false;
            $demo->message = 'Out Of Stock';
        }
        return $demo;

    }


//      cart product
    public function cart_product($carts)
    {
        $carts_decode = json_decode($carts);

        $carts_list = collect();
        foreach ($carts_decode as $cart) {
            $explode_cart = explode("-", $cart);
            $demo_cart = new Demo();
            $demo_cart->productStockId = $explode_cart[0];
            $demo_cart->campaignId = $explode_cart[1];
            $demo_cart->quantity = $explode_cart[2];
            $carts_list->push($demo_cart);
        }


        //modifying cart items to show
        $cart_list = collect();
        $cartProduct = new Cart();
        $t_price = 0;
        $t_tax = 0;
        $total_tax = 0;
        foreach ($carts_list as $cart) {
            $demo_obj = new Demo;
            $productStock = EcomProductVariantStock::where('id', $cart->productStockId)->first();
            if ($productStock != null) {
                $pro = Product::where('id', $productStock->product_id)->first();

                $demo_obj->img = filePath($pro->image);
                $demo_obj->name = $pro->name . ' ' . Str::upper($productStock->product_variants);
                $demo_obj->quantity = $cart->quantity;
                $demo_obj->product_id = $pro->id;
                $demo_obj->vendorStockId = $productStock->id;

                //TODO store variant
                if ($pro->is_discount == false) {
                    /*check this product in campaign*/
                    if ($cart->campaignId != "null") {
                        $campaign = Campaign::where('id', $cart->campaignId)->first();
                        $demo_obj->campaign = $campaign->offer ?? null;
                        $demo_obj->campaign_id = $campaign->id;
                        /*todo:cart campaign product calculation*/
                        $after_offer = ($pro->product_price + $productStock->extra_price) -
                            (($pro->product_price + $productStock->extra_price) * ($campaign->offer / 100));
                        $demo_obj->price_format = formatPrice($after_offer);
                        $demo_obj->price = $after_offer;
                        $demo_obj->sub_price = ($cart->quantity * $after_offer);
                        $demo_obj->sub_price_format = formatPrice($cart->quantity * $after_offer);
                        $t_price += $cart->quantity * $after_offer;
                        $total_tax += (($pro->tax * $t_price) / 100);
                    } else {
                        $demo_obj->campaign = null;
                        $demo_obj->campaign_id = null;
                        $demo_obj->price = ($pro->product_price + $productStock->extra_price);
                        $demo_obj->price_format = formatPrice($pro->product_price + $productStock->extra_price);
                        $demo_obj->sub_price = ($cart->quantity * ($pro->product_price + $productStock->extra_price));
                        $demo_obj->sub_price_format = formatPrice($cart->quantity * ($pro->product_price + $productStock->extra_price));
                        $t_price += $cart->quantity * ($pro->product_price + $productStock->extra_price);
                        $total_tax += (($pro->tax * $t_price) / 100);
                    }

                } else {
                    if ($cart->campaignId != "null") {
                        $campaign = Campaign::where('id', $cart->campaignId)->first();
                        $demo_obj->campaign = $campaign->offer;
                        $demo_obj->campaign_id = $campaign->id;
                        /*todo:cart campaign product calculation*/
                        $after_offer = ($pro->discount_price + $productStock->extra_price) -
                            (($pro->discount_price + $productStock->extra_price) * ($campaign->offer / 100));
                        $demo_obj->price_format = formatPrice($after_offer);
                        $demo_obj->price = $after_offer;
                        $demo_obj->sub_price = ($cart->quantity * $after_offer);
                        $demo_obj->sub_price_format = formatPrice($cart->quantity * $after_offer);
                        $t_price += $cart->quantity * $after_offer; //product total price with quantity
                        $t_tax = ($total_tax + ($total_tax + (($pro->tax * $t_price) / 100)));
                    } else {
                        $demo_obj->campaign = null;
                        $demo_obj->campaign_id = null;
                        $demo_obj->price_format = formatPrice($pro->discount_price + $productStock->extra_price);
                        $demo_obj->price = ($pro->discount_price + $productStock->extra_price);
                        $demo_obj->sub_price = ($cart->quantity * ($pro->discount_price + $productStock->extra_price));
                        $demo_obj->sub_price_format = formatPrice(($cart->quantity * ($pro->discount_price + $productStock->extra_price)));
                        $t_price += $cart->quantity * ($pro->discount_price + $productStock->extra_price);
                        $t_tax = ($total_tax + (($pro->tax * $t_price) / 100));
                    }
                }
                $demo_obj->quantity = (int)$cart->quantity;
                $demo_obj->shopName = '';
                $cart_list->push($demo_obj);
            }

        }
        $cartProduct->sub_total_price = $t_price;
        $cartProduct->sub_total_price_format = formatPrice($t_price);
        $cartProduct->total_price = ($t_price + $t_tax);
        $cartProduct->total_price_format = formatPrice(($t_price + $t_tax));
        $cartProduct->total_tax = $t_tax;
        $cartProduct->total_tax_format = formatPrice($t_tax);
        $cartProduct->cart_list = $cart_list;

        return new ShopCartResource($cartProduct);

    }


    /*checkout*/
    public function checkout(Request $request)
    {

        $user = Auth::user();
        $demo = new Demo();
        try {

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

            /**
             * Generate Order number
             */
            if ($request->payment == "cod" || $request->payment == "paypal" || $request->payment == "stripe") {
                $generate_order_number = Carbon::now()->year . rand('1', '10000');
            } else {
                $generate_order_number = $request->order_id;
            }

            $generate_booking_code = Carbon::now()->year . rand('1', '1000');

            /**
             * DB::Storing to Order
             */

            $order = new EcomOrder();
            $order->user_id = $user->id;
            $order->name = $user->name;
            // Customer Name
            $order->email = $user->email;
            // Customer email
            $order->phone = $request->phone;
            // Customer Phone number
            $order->address = $request->address;
            // Delivery Address
            $order->division_id = $request->division_id; //todo:must be edit
            // Shipping Zone
            $order->area_id = $request->area_id; //todo:must be edit
            // Shipping Area
            $order->note = $request->message;
            // Additional note
            $order->logistic_id = $request->logistic_id; //todo:must be edit
            $logistic = LogisticArea::where('logistic_id', $request->logistic_id)->first();
            // logistic ID
            $order->logistic_charge = $logistic->rate; //todo:must be edit
            // logistic delivery charge
            $order->order_number = $generate_order_number;
            // order number

            if ($request->has('coupon')) {
                $order->applied_coupon = $request->coupon;
                // Applied coupon
            } else {
                $order->applied_coupon = null;
                // No Coupon Applied
            }

            if (!$request->has('total_price')) {
                $order->pay_amount = $request->total_price;
                // total Payment Amount
            } else {
                $order->pay_amount = $request->total_price;
                // total Payment Amount
            }

            $order->payment_type = $request->payment;
            // Payment method
            $order->save();

            /**
             * DB::Storing to OrderProduct
             */


            $booking_code = collect();
            $invoice = collect();
            $booking_id = 0;

            foreach ($carts_list as $cart) {
                $vendorPStock = EcomProductVariantStock::where('id', $cart->productStockId)->first();
                $pro = Product::where('id', $vendorPStock->product_id)->first();
                /*product price*/

                $order_product = new EcomOrderProduct();
                $order_product->user_id = Auth::id();
                $order_product->order_id = $order->id;                              // Order ID
                $order_product->order_number = $order->order_number;                      // Order Number
                $order_product->phone = $order->phone;                                   // Customer Phone
                $order_product->booking_code = $generate_booking_code . $booking_id;      // Booking Code
                $order_product->email = $user->email;                                     // Customer email
                $order_product->product_id = $pro->id;                                      // Product ID
                $order_product->product_stock_id = $vendorPStock->id;                                      // Product ID
                $order_product->sku = $pro->sku;                                   //product sku
                //TODO store variant
                if ($pro->is_discount == false) {
                    /*check this product in campaign*/
                    if ($cart->campaignId != "null") {
                        $campaign = Campaign::where('id', $cart->campaignId)->first();

                        /*todo:cart campaign product calculation*/
                        $after_offer = (($pro->product_price + $vendorPStock->extra_price) -
                            (($pro->product_price + $vendorPStock->extra_price) * ($campaign->offer / 100)));
                        $t_price = $cart->quantity * $after_offer;
                        $tax = (($pro->tax * $t_price) / 100);
                        $price = $t_price + $tax;
                    } else {
                        $t_price = $cart->quantity * ($pro->product_price + $vendorPStock->extra_price);
                        $tax = (($pro->tax * $t_price) / 100);
                        $price = $t_price + $tax;
                    }

                } else {
                    if ($cart->campaignId != "null") {
                        $campaign = Campaign::where('id', $cart->campaignId)->first();
                        /*todo:cart campaign product calculation*/
                        $after_offer = ($pro->discount_price + $vendorPStock->extra_price) -
                            (($pro->discount_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                        $t_price += $cart->quantity * $after_offer; //product total price with quantity
                        $tax = (($pro->tax * $t_price) / 100);
                        $price = $t_price + $tax;
                    } else {

                        $t_price = $cart->quantity * ($pro->discount_price + $vendorPStock->extra_price);
                        $tax = (($pro->tax * $t_price) / 100);
                        $price = $t_price + $tax;
                    }
                }
                $order_product->product_price = $price;             // Product price
                $order_product->quantity = $cart->quantity;                     // Products Quantity
                $order_product->payment_type = $request->payment;                     // Products Quantity

                $order_product->logistic_id = $request->logistic_id; //todo:must be edit                 // logistic ID
                $order_product->status = 'pending';
                // order status
                $order_product->save();
                $booking_id = $order_product->id;
                $booking_code->push($order_product->booking_code);
                $invoice->push($order_product);
            }


            $invoice_number = $order->order_number;

            /**
             * Empty Cart
             */

            $demo->error = false;
            $demo->message = "Dear " . Auth::user()->name .
                " Thank you for your purchase.Your order has been successfully placed. Your Booking code. Please check your email for more details";
        } catch (\Exception $e) {
            $demo->error = true;
            $demo->message = "We are facing some server problem, Try again ";
        }
        /**
         * Generate PDF
         */
        try {
            Mail::to($user->email)->send(new InvoiceMail($user->name, $user->email, $invoice_number, $order));
        } catch (\Exception $exception) {
        }
        return $demo;
    }


    /*order list for ecommerce*/
    public function orderList()
    {
        $orders = EcomOrder::where('user_id', auth()->id())
            ->with('order_product')
            ->with('logistic')
            ->with('area')
            ->with('division')->latest()->get();

        return EcommerceOrderResource::collection($orders);
    }
}
