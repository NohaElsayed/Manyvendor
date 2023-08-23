<?php

namespace App\Http\Controllers\ecommerce;

use App\EcomProductVariantStock;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Demo;
use App\Models\EcomCampaignProduct;
use App\Models\OrderProduct;
use App\Models\EcomOrderProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function searchProduct(Request $request){
        if ($request->key != null){
            $results = Product::where('name', 'LIKE', '%'. $request->key .'%')->get();
        }else{
            $results = collect();
        }
        $total_product = $results->count();
        $key = $request->key;
        return view('frontend.ecommerce.search_product', compact('results', 'total_product','key'));
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
            ->with('variants')
            ->first();

        /*get product variant data*/
        $stock_id = null;
        $product_variants = collect();
        $units_array = array();
        if ($single_product->variants->count() > 0) {
            $v_id = array();
            foreach ($single_product->variants as $vid) {
                array_push($v_id, $vid->variant_id);
            }
            $product_variants = Variant::whereIn('id', $v_id)->get();


            /*for variant unit/ type this data for javascript*/


            $unit = null;
            foreach ($product_variants as $vid) {
                if ($unit == null || $unit = !$vid->unit) {
                    $unit = $vid->unit;
                    array_push($units_array, $vid->unit);
                }
            }
            $units_array = array_unique($units_array);
        } else {
            $stock_id = EcomProductVariantStock::where('product_id', $single_product->id)->first();
            if ($stock_id != null){
                $stock_id = $stock_id->id;
            }
        }


        //same brand
        $brand_products = Product::where('brand_id', $single_product->brand_id)
            ->take(2)
            ->get()
            ->shuffle();


        $related_products = Product::where('category_id', $single_product->category_id)
            ->take(9)
            ->get()
            ->shuffle();

        $order_products = EcomOrderProduct::latest()->where('sku', $single_product->sku)->paginate(10);
        $reviews_count = EcomOrderProduct::whereNotNull('review')->where('sku', $single_product->sku)->count();
        
        return view('frontend.ecommerce.ecom_single_product',
            compact('single_product', 'brand_products', 'related_products', 'reviews_count' ,'product_variants', 'units_array', 'order_products', 'stock_id'));
    }

    /* category product*/
    public function category_product($slug)
    {

        $parent_slug = null;
        $cat = Category::where('slug', $slug)->Published()->with('childrenCategories')->first();
        if ($cat->childrenCategories->count() > 0) {
            $parent_slug = $cat->slug;
            $category_products = Category::where('slug', $slug)->Published()->with('frontCategoryProducts')->get();
        } else {
            $category_products = Category::where('slug', $slug)->Published()->with('subCategoryProducts')->get();
            $pid = 0;
            foreach ($category_products as $cat_product) {
                $pid = $cat_product->parent_category_id;
            }

            $p = Category::where('id', $pid)->first();
            $parent_slug = Category::where('id', $p->parent_category_id)->first()->slug;

        }
        $total_product = 0;
        foreach ($category_products as $category_product) {
            if ($category_product->subCategoryProducts->count() > 0) {
                $total_product += $category_product->subCategoryProducts->count();
            }

            foreach ($category_product->frontCategoryProducts as $cat_product) {
                if ($cat_product->CategoryProducts->count() > 0) {
                    $total_product += $cat_product->CategoryProducts->count();
                }
            }
        }


        return view('frontend.ecommerce.category_product', compact('category_products', 'cat', 'total_product', 'parent_slug'));
    }

    /*all product*/
    public function allProduct()
    {
        return view('frontend.ecommerce.all_product');
    }

    /*show  product variant*/
    public function variantWaysProduct(Request $request)
    {

        $free_delivery = translate('Free Delivery');
        $product = Product::where('id', $request->productId)->first();
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
            $productVariantStock = EcomProductVariantStock::where('product_variants_id', 'LIKE', '%' . $string . '%')
                ->where('product_id', $request->productId)
                ->Published()
                ->Active()
                ->first();

        } else {
            $productVariantStock = EcomProductVariantStock::where('product_id', $request->productId)
                ->Published()
                ->Active()
                ->first();
        }

        $demo = new Demo();
        /*create demo ecommerce product details*/
        if ($productVariantStock != null && $product != null) {

            /*here the design in frontend*/
            $demo->stock_out = $productVariantStock->quantity <= 1 ? 'out_of_stock' : null;
            if ($demo->stock_out == 'out_of_stock') {
                $demo->stock_out = @translate('Out Of Stock');
                $demo->display = 'd-none';
                $demo->reverse_display = null;
                $demo->stock = false;
            } else {
                $demo->stock = true;
                $demo->stock_out = @translate('Add To Cart ');
                $demo->display = null;
                $demo->reverse_display = 'd-none';
            }
            $price = 0;
            if ($product->is_discount > 0) {
                $price = $product->discount_price;
                $demo->discount_text = translate('Discount ') . number_format($product->discount_percentage) . '%';
            } else {
                $demo->discount_text = translate('No discount available');
                $price = $product->product_price;
            }
            $demo->price_format = formatPrice($price);
            $demo->price = $price;
            $demo->extra_price_format = translate('Extra Price ') . formatPrice($productVariantStock->extra_price);
            $demo->extra_price = $productVariantStock->extra_price;
            $demo->total_price_format = formatPrice($price + $productVariantStock->extra_price);
            $demo->total_price = $price + $productVariantStock->extra_price;
            $demo->product_stock_id = $productVariantStock->id;
            $demo->variant_str = Str::upper($productVariantStock->product_variants);
            $demo->product_id = $productVariantStock->product_id;

        }


        return response()->json(['data' => $demo], 200);
    }


    //show campaign products
    public function show_campaign_product($slug)
    {
        $campaign = Campaign::where('slug', $slug)->first();
        //todo get products from relation by creating demo object
        $products = EcomCampaignProduct::where('campaign_id', $campaign->id)->with('product')->get();

        //modifying product items to show in campaign products list
        $product_list = collect();
        foreach ($products as $pro) {
            if ($pro->product != null) {
                $demo_obj = new Demo;
                $demo_obj->coampaign_product_id = $pro->id;
                $demo_obj->image = filePath($pro->product->image);
                $demo_obj->name = $pro->product->name;
                $demo_obj->have_variant = $pro->product->have_variant;
                $demo_obj->product_id = $pro->product->id;
                $demo_obj->campaign_id = $campaign->id;
                /*check have variant*/
                if (!$demo_obj->have_variant) {
                    $stock = EcomProductVariantStock::where('product_id', $demo_obj->product_id)->first();
                    $demo_obj->product_variant_stock_id = $stock->id;

                    $demo_obj->quantity = $stock->quantity;
                }


                $demo_obj->sku = $pro->product->sku;
                $demo_obj->slug = $pro->product->slug;

                //TODO take variant boolean, price of product reducing campaign offer %
                if ($pro->product->is_discount == false) {
                    $demo_obj->price = formatPrice($pro->product->product_price);
                } else {
                    $demo_obj->price = formatPrice($pro->product->discount_price);
                }
                $product_list->push($demo_obj);
            }

        }

        return view('frontend.ecommerce.campaign_product', compact('campaign', 'product_list'));
    }

    /*campaign product variant*/
    public function variantPro($product_id, $campaign_id)
    {
        $pstock = EcomProductVariantStock::where('product_id', $product_id)->get();
        return view('frontend.ecommerce.variantProduct', compact('pstock', 'campaign_id'));
    }

}
