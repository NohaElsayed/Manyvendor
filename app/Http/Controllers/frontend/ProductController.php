<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Demo;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Variant;
use App\Models\OrderProduct;
use App\Models\VendorProductVariantStock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{


    public function searchProduct(Request $request){
        if ($request->key != null){
            $results = Product::where('name', 'LIKE', '%'. $request->key .'%')->get();
        }else{
            $results =  collect();
        }
        $total_product = $results->count();
        $key = $request->key;
        return view('frontend.shop.search_product', compact('results', 'total_product','key'));
    }
    // single_product
    public function single_product($sku, $slug)
    {

        $single_product = Product::where('sku', $sku)
            ->where('slug', $slug)
            ->with('images')
            ->with('brand')
            ->with('category')
            ->with('childcategory')
            ->with('vendorProduct')
            ->with('variants')
            ->first();

        /*get product variant data*/
        $product_variants= collect();
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


        //same brand
        $brand_products = Product::where('brand_id', $single_product->brand_id)
            ->with('sellers')
            ->take(2)
            ->get()
            ->shuffle();


        $related_products = Product::where('category_id', $single_product->category_id)
            ->with('sellers')
            ->take(8)
            ->get()
            ->shuffle();


            $products_count = Product::where('category_id', $single_product->category_id)
            ->with('sellers')
            ->count();

        $order_products = OrderProduct::latest()->where('sku', $single_product->sku)->paginate(10);
        $reviews_count = OrderProduct::whereNotNull('review')->where('sku', $single_product->sku)->count();

        return view('frontend.product.single_product',
            compact('single_product', 'brand_products', 'related_products', 'product_variants', 'units_array', 'order_products', 'reviews_count','products_count'));

    }

    // quick_view
    public function quick_view($slug)
    {
        $quick_product = Product::where('slug', $slug)->first();
        return view('frontend.include.product.quickview', compact('quick_product'));
    }


    /*show variant ways seller*/
    public function variant_ways_seller(Request $request)
    {
        $sellers = collect();
        if ($request->id != null) {
            $product_variant = ProductVariant::where('product_id', $request->productId)->whereIn('variant_id', $request->id)->get();
            $id = "";
            foreach ($product_variant as $vc) {
                $id .= $vc->id . '-';
            }

            /*this string for like match in vendor product variant stock table*/
            $string = substr($id, 0, -1);
            /*get table data*/

            /*todo:next update we change it*/
            $vpvariantStock = VendorProductVariantStock::where('product_variants_id', 'LIKE', '%' . $string . '%')
                                                        ->where('product_id', $request->productId)
                                                        ->with('vendorProduct')
                                                        ->with('user')
                                                        ->Published()
                                                        ->Active()
                                                        ->get()
                                                        ->shuffle();

        }else{
            $vpvariantStock = VendorProductVariantStock::where('product_id', $request->productId)
                                                        ->with('vendorProduct')
                                                        ->with('user')
                                                        ->Published()
                                                        ->Active()
                                                        ->get()
                                                        ->shuffle();
        }



        /*create demo seller details*/

        foreach ($vpvariantStock as $seller) {
            if ($seller->user->vendor != null) {
                $demo = new Demo();
                $demo->user_id = $seller->user->vendor->user_id;
                $demo->name = $seller->user->vendor->name;
                $demo->email = $seller->user->vendor->email;
                $demo->vendor_id = $seller->user->vendor->id;
                /*here the design in frontend*/
                $demo->stock_out = $seller->quantity <= 1 ? 'out_of_stock' : 'have_stock';
                if ($demo->stock_out == 'out_of_stock'){
                    $demo->display = 'd-none';
                    $demo->reverse_display = null;
                    $demo->stock = true;
                }else{
                    $demo->stock = false;
                    $demo->display = null;
                    $demo->reverse_display = 'd-none';
                }
                $price = 0;
                if ($seller->vendorProduct->is_discount > 0) {
                    $price = $seller->vendorProduct->discount_price;
                    $demo->discount_text = translate('Discount ') . number_format($seller->vendorProduct->discount_percentage - 100).'%';
                } else {
                    $demo->discount_text = translate('No discount available');
                    $price = $seller->vendorProduct->product_price;
                }
                $demo->price_format = formatPrice($price);
                $demo->price = $price;
                $demo->extra_price_format = translate('Extra Price ') . formatPrice($seller->extra_price);
                $demo->extra_price = $seller->extra_price;
                $demo->total_price_format = formatPrice($price + $seller->extra_price);
                $demo->total_price = $price + $seller->extra_price;
                if (empty($seller->user->vendor->shop_logo)) {
                    $demo->shop_logo = asset('vendor-store.jpg');
                } else {
                    $demo->shop_logo = filePath($seller->user->vendor->shop_logo);
                }
                $demo->slug = $seller->user->vendor->slug;
                $demo->vendor_stock_id = $seller->id;
                $demo->variant = Str::upper($seller->product_variants);
                $demo->vendor_product_id = $seller->vendor_product_id;
                $demo->vendor_link = route('vendor.shop', $seller->user->vendor->slug);
                $demo->rateing = 2; //this is seller/vendor rating
                $demo->product_id = $seller->product_id;
                $sellers->push($demo);
            }
        }

        return response()->json(['data' => $sellers], 200);
    }

    /**
     * getvendor
     */
    public function getvendor(Request $request)
    {

        $vendor_variants = VendorProductVariantStock::where('product_variants_id', 1)
            ->with('vendor_product')
            ->get();

        foreach ($vendor_variants as $vendors) {
            $items = $vendors->vendor_product;
            foreach ($items as $item) {
                return $item->products->shop_name;
            }
        }

    }
}
