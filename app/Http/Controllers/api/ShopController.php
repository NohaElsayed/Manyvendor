<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ShopCampaignResource;
use App\Http\Resources\ShopCartResource;
use App\Http\Resources\ShopSingleProduct;
use App\Http\Resources\VendorOrderResource;
use App\Http\Resources\VendorProductResource;
use App\Http\Resources\VendorProductResourct;
use App\Http\Resources\VendorResource;
use App\Mail\InvoiceMail;
use App\Models\Brand;
use App\Models\Campaign;
use App\Models\CampaignProduct;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Demo;
use App\Models\Logistic;
use App\Models\LogisticArea;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VendorProductVariantStock;
use App\User;
use App\Vendor;
use App\VendorProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ShopController extends Controller
{

    /*get shop*/
    public function get_shops()
    {
        $users = collect();
        $shops = User::with('vendor')->where('user_type', 'Vendor')->where('banned', 0)->with('productCount')->get()->shuffle();
        foreach ($shops as $shop){
            if ($shop->vendor != null){
                $users->push($shop);
            }
        }

        return VendorResource::collection($users);
    }

    /*search product*/
    public function search_product($name)
    {
        if ($name == 'all') {
            $products = Product::Published()->get()->shuffle()->take(20);
        } else {
            $products = Product::Published()->where('name', 'LIKE', '%' . $name . '%')->get()->take(20);
        }

        $vendor_product = collect();
        foreach ($products as $pro) {
            $demo = new Demo();
            $demo->product_id = $pro->id;
            $demo->sku = $pro->sku;
            $demo->slug = $pro->slug;
            $demo->name = $pro->name;
            if($pro->image == null){
                $demo->image = filePath('comparison.png');
            }else{
                $demo->image = filePath($pro->image);
            }
            $demo->discount = formatPrice(brandProductSalePrice($pro->vendorProduct)->min())
            == formatPrice(brandProductSalePrice($pro->vendorProduct)->max())
                ? formatPrice(brandProductSalePrice($pro->vendorProduct)->min())
                : formatPrice(brandProductSalePrice($pro->vendorProduct)->min()) .
                '-' . formatPrice(brandProductSalePrice($pro->vendorProduct)->max());
            if ($demo->discount == formatPrice(0)) {
                $demo->discountHave = false;
            } else {
                $demo->discountHave = true;
            }
            $demo->price = formatPrice(brandProductPrice($pro->vendorProduct)->min())
            == formatPrice(brandProductPrice($pro->vendorProduct)->max())
                ? formatPrice(brandProductPrice($pro->vendorProduct)->min())
                : formatPrice(brandProductPrice($pro->vendorProduct)->min()) .
                '-' . formatPrice(brandProductPrice($pro->vendorProduct)->max());
            $vendor_product->push($demo);
        }
        return VendorProductResource::collection($vendor_product);
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
                $demo->discount = formatPrice(brandProductSalePrice($pro->vendorProduct)->min())
                == formatPrice(brandProductSalePrice($pro->vendorProduct)->max())
                    ? formatPrice(brandProductSalePrice($pro->vendorProduct)->min())
                    : formatPrice(brandProductSalePrice($pro->vendorProduct)->min()) .
                    '-' . formatPrice(brandProductSalePrice($pro->vendorProduct)->max());
                if ($demo->discount == formatPrice(0)) {
                    $demo->discountHave = false;
                } else {
                    $demo->discountHave = true;
                }
                $demo->price = formatPrice(brandProductPrice($pro->vendorProduct)->min())
                == formatPrice(brandProductPrice($pro->vendorProduct)->max())
                    ? formatPrice(brandProductPrice($pro->vendorProduct)->min())
                    : formatPrice(brandProductPrice($pro->vendorProduct)->min()) .
                    '-' . formatPrice(brandProductPrice($pro->vendorProduct)->max());
                $vendor_product->push($demo);
            }
        }
        return VendorProductResource::collection($vendor_product);
    }

    //show
    public function trendingProducts()
    {
        $vendor_product = collect();
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
                $demo->discount = formatPrice(brandProductSalePrice($product->sellers)->min())
                == formatPrice(brandProductSalePrice($product->sellers)->max())
                    ? formatPrice(brandProductSalePrice($product->sellers)->min())
                    : formatPrice(brandProductSalePrice($product->sellers)->min()) .
                    '-' . formatPrice(brandProductSalePrice($product->sellers)->max());
                if ($demo->discount == formatPrice(0)) {
                    $demo->discountHave = false;
                } else {
                    $demo->discountHave = true;
                }
                $demo->price = formatPrice(brandProductPrice($product->sellers)->min()) == formatPrice(brandProductPrice($product->sellers)->max())
                    ? formatPrice(brandProductPrice($product->sellers)->min()) : formatPrice(brandProductPrice($product->sellers)->min()) .
                    '-' . formatPrice(brandProductPrice($product->sellers)->max());
                $vendor_product->push($demo);

                if ($b_value == 2) {
                    break;
                }
            }
        }
        return VendorProductResource::collection($vendor_product);
    }

    /*vendor shops*/
    public function vendor_shop_product($id)
    {

        $seller_store = Vendor::where('id', $id)->first();
        $products = VendorProduct::where('user_id', $seller_store->user_id)->with('product')->get()->shuffle();
        $vendor_product = collect();

        foreach ($products as $vendorProduct) {
            $demo = new Demo();
            $demo->product_id = $vendorProduct->product_id;
            $demo->sku = $vendorProduct->product->sku;
            $demo->slug = $vendorProduct->product->slug;
            $demo->name = $vendorProduct->product->name;
            $demo->image = filePath($vendorProduct->product->image);
            $demo->discount = formatPrice(brandProductSalePrice($vendorProduct->product->sellers)->min())
            == formatPrice(brandProductSalePrice($vendorProduct->product->sellers)->max())
                ? formatPrice(brandProductSalePrice($vendorProduct->product->sellers)->min())
                : formatPrice(brandProductSalePrice($vendorProduct->product->sellers)->min()) .
                '-' . formatPrice(brandProductSalePrice($vendorProduct->product->sellers)->max());
            if ($demo->discount == formatPrice(0)) {
                $demo->discountHave = false;
            } else {
                $demo->discountHave = true;
            }
            $demo->price = formatPrice(brandProductPrice($vendorProduct->product->sellers)->min())
            == formatPrice(brandProductPrice($vendorProduct->product->sellers)->max())
                ? formatPrice(brandProductPrice($vendorProduct->product->sellers)->min())
                : formatPrice(brandProductPrice($vendorProduct->product->sellers)->min()) .
                '-' . formatPrice(brandProductPrice($vendorProduct->product->sellers)->max());
            $vendor_product->push($demo);
        }
        return VendorProductResource::collection($vendor_product);
    }


    public function brand_shop($slug)
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
            $demo->discount = formatPrice(brandProductSalePrice($pro->vendorProduct)->min())
            == formatPrice(brandProductSalePrice($pro->vendorProduct)->max())
                ? formatPrice(brandProductSalePrice($pro->vendorProduct)->min())
                : formatPrice(brandProductSalePrice($pro->vendorProduct)->min()) .
                '-' . formatPrice(brandProductSalePrice($pro->vendorProduct)->max());
            if ($demo->discount == formatPrice(0)) {
                $demo->discountHave = false;
            } else {
                $demo->discountHave = true;
            }
            $demo->price = formatPrice(brandProductPrice($pro->vendorProduct)->min())
            == formatPrice(brandProductPrice($pro->vendorProduct)->max())
                ? formatPrice(brandProductPrice($pro->vendorProduct)->min())
                : formatPrice(brandProductPrice($pro->vendorProduct)->min()) .
                '-' . formatPrice(brandProductPrice($pro->vendorProduct)->max());
            $vendor_product->push($demo);

        }
        return VendorProductResource::collection($vendor_product);

    }

    /*show single product*/
    public function single_product($id)
    {


        $single_product = Product::where('id', $id)
            ->with('images')
            ->with('brand')
            ->with('category')
            ->with('childcategory')
            ->with('vendorProduct')
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
        $demo->discount = formatPrice(brandProductSalePrice($single_product->vendorProduct)->min())
        == formatPrice(brandProductSalePrice($single_product->vendorProduct)->max())
            ? formatPrice(brandProductSalePrice($single_product->vendorProduct)->min())
            : formatPrice(brandProductSalePrice($single_product->vendorProduct)->min()) .
            '-' . formatPrice(brandProductSalePrice($single_product->vendorProduct)->max());
        if ($demo->discount == formatPrice(0)) {
            $demo->discountHave = false;
        } else {
            $demo->discountHave = true;
        }

        $demo->price = formatPrice(brandProductPrice($single_product->vendorProduct)->min())
        == formatPrice(brandProductPrice($single_product->vendorProduct)->max())
            ? formatPrice(brandProductPrice($single_product->vendorProduct)->min())
            : formatPrice(brandProductPrice($single_product->vendorProduct)->min()) .
            '-' . formatPrice(brandProductPrice($single_product->vendorProduct)->max());

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
        foreach ($units_array as $unit){
            $ns  = new Demo();
            $ns->unit = $unit;

            /*get variant by unit*/
            $variant = collect();
            foreach ($product_variants->where('unit',$unit) as $vs) {

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

        /*all variant product*/
        $vpvariantStock = VendorProductVariantStock::where('product_id', $single_product->id)
            ->with('vendorProduct')
            ->with('user')
            ->Published()
            ->Active()
            ->get()
            ->shuffle();

        /*create demo seller details*/
        $shops = collect();
        foreach ($vpvariantStock as $seller) {
            if ($seller->user->vendor != null) {
                $shop = new Vendor();
                $shop->name = $seller->user->vendor->name;
                $shop->email = $seller->user->vendor->email;
                $shop->vendorId = $seller->user->vendor->id;
                $shop->rating = shopRating($shop->vendorId);
                /*here the design in frontend*/
                $shop->stockOut = $seller->quantity <= 1 ? true : false;

                if ($seller->vendorProduct->is_discount > 0) {
                    $price = $seller->vendorProduct->discount_price;
                    $shop->discountText = translate('Discount ') . number_format($seller->vendorProduct->discount_percentage - 100) . '%';
                } else {
                    $shop->discountText = translate('No discount available');
                    $price = $seller->vendorProduct->product_price;
                }
                $shop->priceFormat = formatPrice($price);
                $shop->price = $price;
                $shop->extraPriceFormat = translate('Extra Price ') . formatPrice($seller->extra_price);
                $shop->extraPrice = $seller->extra_price;
                $shop->totalPriceFormat = formatPrice($price + $seller->extra_price);
                $shop->totalPrice = $price + $seller->extra_price;
                if (empty($seller->user->vendor->shop_logo)) {
                    $shop->shopLogo = asset('vendor-store.jpg');
                } else {
                    $shop->shopLogo = filePath($seller->user->vendor->shop_logo);
                }
                $shop->slug = $seller->user->vendor->slug;
                $shop->vendorStockId = $seller->id;
                $shop->variant = Str::upper($seller->product_variants);
                $shops->push($shop);
            }
        }
        $demo->shops = $shops;

        return new ShopSingleProduct($demo);

    }

    public function get_cat_product($id)
    {
        $vendor_product = collect();
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
                $demo->discount = formatPrice(brandProductSalePrice($pro->vendorProduct)->min())
                == formatPrice(brandProductSalePrice($pro->vendorProduct)->max())
                    ? formatPrice(brandProductSalePrice($pro->vendorProduct)->min())
                    : formatPrice(brandProductSalePrice($pro->vendorProduct)->min()) .
                    '-' . formatPrice(brandProductSalePrice($pro->vendorProduct)->max());
                if ($demo->discount == formatPrice(0)) {
                    $demo->discountHave = false;
                } else {
                    $demo->discountHave = true;
                }
                $demo->price = formatPrice(brandProductPrice($pro->vendorProduct)->min())
                == formatPrice(brandProductPrice($pro->vendorProduct)->max())
                    ? formatPrice(brandProductPrice($pro->vendorProduct)->min())
                    : formatPrice(brandProductPrice($pro->vendorProduct)->min()) .
                    '-' . formatPrice(brandProductPrice($pro->vendorProduct)->max());
                $vendor_product->push($demo);
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
                $demo->discount = formatPrice(brandProductSalePrice($pro->vendorProduct)->min())
                == formatPrice(brandProductSalePrice($pro->vendorProduct)->max())
                    ? formatPrice(brandProductSalePrice($pro->vendorProduct)->min())
                    : formatPrice(brandProductSalePrice($pro->vendorProduct)->min()) .
                    '-' . formatPrice(brandProductSalePrice($pro->vendorProduct)->max());
                if ($demo->discount == formatPrice(0)) {
                    $demo->discountHave = false;
                } else {
                    $demo->discountHave = true;
                }
                $demo->price = formatPrice(brandProductPrice($pro->vendorProduct)->min())
                == formatPrice(brandProductPrice($pro->vendorProduct)->max())
                    ? formatPrice(brandProductPrice($pro->vendorProduct)->min())
                    : formatPrice(brandProductPrice($pro->vendorProduct)->min()) .
                    '-' . formatPrice(brandProductPrice($pro->vendorProduct)->max());
                $vendor_product->push($demo);
            }
        }

        return VendorProductResource::collection($vendor_product);
    }


    public function campaign_product($id)
    {
        $product_list = collect();
        $vpvs_id = 0;
        $stockOut = false;
        $campaign = Campaign::where('id', $id)->On()->first();
        if ($campaign != null) {
            $products = CampaignProduct::where('campaign_id', $campaign->id)->get();
            //modifying product items to show in campaign products list
            foreach ($products as $product) {
                /*campaign product*/
                $pro = $product->campaignProductFromShop->where('id', $product->vendor_product_id)->first();
                if ($pro->frontProduct != null) {
                    $demo_obj = new Demo();
                    $demo_obj->product_id = $product->id;
                    $demo_obj->image = filePath($pro->product->image);
                    $demo_obj->name = $pro->frontProduct->name;
                    $demo_obj->campaign_id = $campaign->id;
                    $demo_obj->quantity = $product->quantity;
                    $demo_obj->rating = shopRating($product->vendor_id);
                    $shops = collect();
                    if (!$pro->have_variant) {
                        $vpvs = VendorProductVariantStock::where('user_id', $product->vendor_id)->where('vendor_product_id', $product->vendor_product_id)->first();
                        $stockOut = $vpvs->quantity <= 1 ? true : false;
                        $vpvs_id = $vpvs->id;
                    } else {
                        $stock = VendorProductVariantStock::where('user_id', $product->vendor_id)->where('vendor_product_id', $product->vendor_product_id)->get();
                        foreach ($stock as $seller) {
                            if ($seller->user->vendor != null) {
                                $shop = new Vendor();
                                $shop->vendorId = $seller->user->vendor->id;
                                /*here the design in frontend*/
                                $shop->stockOut = $seller->quantity <= 1 ? true : false;

                                if ($seller->vendorProduct->is_discount > 0) {
                                    $price = $seller->vendorProduct->discount_price;
                                    $shop->discountText = translate('Discount ') . number_format($seller->vendorProduct->discount_percentage - 100) . '%';
                                } else {
                                    $shop->discountText = translate('No discount available');
                                    $price = $seller->vendorProduct->product_price;
                                }
                                $shop->priceFormat = formatPrice($price);
                                $shop->price = $price;
                                $shop->extraPriceFormat = translate('Extra Price ') . formatPrice($seller->extra_price);
                                $shop->extraPrice = $seller->extra_price;
                                $shop->totalPriceFormat = formatPrice($price + $seller->extra_price);
                                $shop->totalPrice = $price + $seller->extra_price;
                                $shop->vendorStockId = $seller->id;
                                $shop->variant = Str::upper($seller->product_variants);
                                $shops->push($shop);
                            }
                        }
                    }
                    $demo_obj->stockOut = $stockOut;
                    $demo_obj->shops = $shops;
                    $demo_obj->variant_stock_id = $vpvs_id;

                    //TODO take variant boolean, price of product reducing campaign offer %
                    if ($pro->is_discount == false) {
                        $demo_obj->price = formatPrice($pro->product_price);
                    } else {
                        $demo_obj->price = formatPrice($pro->discount_price);
                    }
                    $demo_obj->shop_name = $product->campaignProductFromShop->user->vendor->shop_name;
                    $product_list->push($demo_obj);
                }

            }
        }
        return ShopCampaignResource::collection($product_list);
    }


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
            $vendorPStock = VendorProductVariantStock::where('id', $cart->productStockId)->first();
            $pro = VendorProduct::where('id', $vendorPStock->vendor_product_id)->with('product')->first();

            $demo_obj->img = filePath($pro->product->image);
            $demo_obj->name = $pro->product->name . ' ' . Str::upper($vendorPStock->product_variants);
            $demo_obj->quantity = $cart->quantity;
            $demo_obj->product_id = $pro->product->id;
            $demo_obj->vendorStockId = $vendorPStock->id;

            //TODO store variant
            if ($pro->is_discount == false) {
                /*check this product in campaign*/
                if ($cart->campaignId != "null") {
                    $campaign = Campaign::where('id', $cart->campaignId)->first();
                    $demo_obj->campaign = $campaign->offer ?? null;
                    $demo_obj->campaign_id = $campaign->id;
                    /*todo:cart campaign product calculation*/
                    $after_offer = ($pro->product_price + $vendorPStock->extra_price) -
                        (($pro->product_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price_format = formatPrice($after_offer);
                    $demo_obj->price = $after_offer;
                    $demo_obj->sub_price = ($cart->quantity * $after_offer);
                    $demo_obj->sub_price_format = formatPrice($cart->quantity * $after_offer);
                    $t_price += $cart->quantity * $after_offer;
                    $total_tax += (($pro->product->tax * $t_price) / 100);
                }
                else {
                    $demo_obj->campaign = null;
                    $demo_obj->campaign_id = null;
                    $demo_obj->price = ($pro->product_price + $vendorPStock->extra_price);
                    $demo_obj->price_format = formatPrice($pro->product_price + $vendorPStock->extra_price);
                    $demo_obj->sub_price = ($cart->quantity * ($pro->product_price + $vendorPStock->extra_price));
                    $demo_obj->sub_price_format = formatPrice($cart->quantity * ($pro->product_price + $vendorPStock->extra_price));
                    $t_price += $cart->quantity * ($pro->product_price + $vendorPStock->extra_price) ;
                    $total_tax += (($pro->product->tax * $t_price) / 100);
                }

            }
            else {
                if ($cart->campaignId != "null") {
                    $campaign = Campaign::where('id', $cart->campaignId)->first();
                    $demo_obj->campaign = $campaign->offer;
                    $demo_obj->campaign_id = $campaign->id;
                    /*todo:cart campaign product calculation*/
                    $after_offer = ($pro->discount_price + $vendorPStock->extra_price) -
                        (($pro->discount_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                    $demo_obj->price_format = formatPrice($after_offer);
                    $demo_obj->price = $after_offer;
                    $demo_obj->sub_price = ($cart->quantity * $after_offer);
                    $demo_obj->sub_price_format = formatPrice($cart->quantity * $after_offer);
                    $t_price += $cart->quantity * $after_offer; //product total price with quantity
                    $t_tax = ($total_tax+ ($total_tax+ (($pro->product->tax * $t_price) / 100)));
                }
                else {
                    $demo_obj->campaign = null;
                    $demo_obj->campaign_id = null;
                    $demo_obj->price_format = formatPrice($pro->discount_price + $vendorPStock->extra_price);
                    $demo_obj->price = ($pro->discount_price + $vendorPStock->extra_price);
                    $demo_obj->sub_price =($cart->quantity * ($pro->discount_price +$vendorPStock->extra_price));
                    $demo_obj->sub_price_format = formatPrice(($cart->quantity * ($pro->discount_price +$vendorPStock->extra_price)));
                    $t_price += $cart->quantity * ($pro->discount_price +$vendorPStock->extra_price);
                    $t_tax = ($total_tax+ (($pro->product->tax * $t_price) / 100));
                }
            }
            $demo_obj->quantity = (int)$cart->quantity;
            $demo_obj->shop_name = Vendor::where('user_id', $pro->user_id)->first()->shop_name;
            $cart_list->push($demo_obj);
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
    public function checkout(Request  $request){

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
            if($request->payment == "cod" || $request->payment == "paypal" || $request->payment == "stripe"){
                $generate_order_number = Carbon::now()->year . rand('1', '10000');
            }else{
                $generate_order_number = $request->order_id;
            }

            $generate_booking_code = Carbon::now()->year . rand('1', '1000');

            /**
             * DB::Storing to Order
             */

            $order = new Order();
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
            $logistic  = LogisticArea::where('logistic_id',$request->logistic_id)->first();
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
        $t_price = 0;

            foreach ($carts_list as $cart) {
                $vendorPStock = VendorProductVariantStock::where('id', $cart->productStockId)->first();
                $pro = VendorProduct::where('id', $vendorPStock->vendor_product_id)->with('product')->first();
                /*product price*/

                $order_product = new OrderProduct();
                $order_product->user_id = Auth::id();
                $order_product->order_id = $order->id;                              // Order ID
                $order_product->order_number = $order->order_number;                      // Order Number
                $order_product->phone = $order->phone;                                   // Customer Phone
                $order_product->booking_code = $generate_booking_code . $booking_id;      // Booking Code
                $order_product->email = $user->email;                                     // Customer email
                $order_product->product_id = $pro->product->id;                                      // Product ID
                $order_product->sku = $pro->product->sku;                                   //product sku
//TODO store variant
                if ($pro->is_discount == false) {
                    /*check this product in campaign*/
                    if ($cart->campaignId != "null") {
                        $campaign = Campaign::where('id', $cart->campaignId)->first();

                        /*todo:cart campaign product calculation*/
                        $after_offer = (($pro->product_price + $vendorPStock->extra_price) -
                            (($pro->product_price + $vendorPStock->extra_price) * ($campaign->offer / 100)));
                        $t_price = $cart->quantity * $after_offer;
                        $tax= (($pro->product->tax * $t_price) / 100);
                        $price = $t_price + $tax;
                    }
                    else {
                        $t_price = $cart->quantity * ($pro->product_price + $vendorPStock->extra_price) ;
                        $tax = (($pro->product->tax * $t_price) / 100);
                        $price = $t_price + $tax;
                    }

                }
                else {
                    if ($cart->campaignId != "null") {
                        $campaign = Campaign::where('id', $cart->campaignId)->first();
                        /*todo:cart campaign product calculation*/
                        $after_offer = ($pro->discount_price + $vendorPStock->extra_price) -
                            (($pro->discount_price + $vendorPStock->extra_price) * ($campaign->offer / 100));
                        $t_price += $cart->quantity * $after_offer; //product total price with quantity
                        $tax = (($pro->product->tax * $t_price) / 100);
                        $price = $t_price + $tax;
                    }
                    else {

                        $t_price = $cart->quantity * ($pro->discount_price +$vendorPStock->extra_price);
                        $tax = (($pro->product->tax * $t_price) / 100);
                        $price = $t_price + $tax;
                    }
                }
                $order_product->product_price = $price;             // Product price
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



            $invoice_number = $order->order_number;

            /**
             * Empty Cart
             */

            $demo->error = false;
            $demo->message = "Dear ".Auth::user()->name.
                " Thank you for your purchase.Your order has been successfully placed. Please check your email for more details";
        }catch (\Exception $e){
            $demo->error = true;
            $demo->message = "The Network Connection is Lost, Try again ";
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


    /*order list for vendor*/
    public function orderList(){//
        $orders = Order::where('user_id',auth()->id())
            ->with('order_product')
            ->with('logistic')
            ->with('area')
            ->with('division')->latest()->get();

        return VendorOrderResource::collection($orders);
    }

}
