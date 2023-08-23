<?php

namespace App\Http\Controllers\frontend\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\VendorProduct;
use App\Vendor;
use App\Models\Promotion;

class ShopController extends Controller
{
    // index
    public function index()
    {
        return view('frontend.shop.shop_default');
    }

    // category_shop
    public function category_shop($slug)
    {
        $parent_slug = null;
        $cat = Category::where('slug', $slug)->Published()->with('childrenCategories')->first();
        if($cat != null){
        if ($cat->childrenCategories->count() > 0) {
             $parent_slug = $cat->slug;
            $category_products = Category::where('slug', $slug)->Published()->with('frontCategoryProducts')->get();
        }
        else {
            $category_products = Category::where('slug', $slug)->Published()->with('subCategoryProducts')->get();
            $pid =0;
            foreach ($category_products as $cat_product) {
                $pid = $cat_product->parent_category_id;
            }

            $p =Category::where('id', $pid)->first();
            $parent_slug =Category::where('id', $p->parent_category_id)->first()->slug;

        }
        $total_product = 0;
        foreach ($category_products as $category_product) {
            if ($category_product->subCategoryProducts->count() >0){
                $total_product += $category_product->subCategoryProducts->count();
            }

            foreach ($category_product->frontCategoryProducts as $cat_product) {
                if ($cat_product->CategoryProducts->count() > 0){
                    $total_product += $cat_product->CategoryProducts->count();
                }
            }
        }


        return view('frontend.shop.category_shop', compact('category_products', 'cat','total_product','parent_slug'));
        }else{
            return  redirect()->to('/');
        }
    }


    // brand_shop
    public function brand_shop($slug)
    {
        $total_product = Brand::where('slug', $slug)->Published()->with('products')->count();
        $brand_products = Brand::where('slug', $slug)->Published()->with('products')->get();

        $total_brand_product = 0;
        foreach ($brand_products as $brand_product) {
            $total_brand_product += $brand_product->products->count();
        }

        return view('frontend.shop.brand_shop', compact('total_product','brand_products','total_brand_product'));
    }


    /**
     * FILTER
     */

     public function filter(Request $request)
     {
         /**latest */
        if ($request->sortby == 'latest') {
            $filters = Product::latest()->paginate(50);
            return view('frontend.shop.filter',compact('filters'));
        }

     }


    /**
     * Search Header
     */

     public function search_header(Request $request)
     {
         if ($request->type == 'product') {
             $results = Product::where('name', 'LIKE', '%'. $request->input .'%')->get();

             $sendData = '';
             foreach($results as $result)
             {
                $sendData .=
                // '<tr>
                //     <td class="w-20">
                //         <a href='. route('single.product',[$result->sku,$result->slug]) .' class="img-fluid"  alt='.$result->name.'>
                //             <img src='.filePath($result->image).' class="img-fluid w-50" alt='.$result->name.'>
                //         </a>
                //     <td>
                //     <td class="padding-20">
                //         <a href='. route('single.product',[$result->sku,$result->slug])  .'>' . $result->name . '</a>
                //     </td>
                // </tr>
                // ';
                '
                <div class="col-3">
                    <a href='. route('single.product',[$result->sku,$result->slug]) .' class="img-fluid"  alt='.$result->name.'>
                        <img src='.filePath($result->image).' class="img-fluid w-50" alt='.$result->name.'>
                    </a>
                </div>
                <div class="col-9">
                    <a href='. route('single.product',[$result->sku,$result->slug])  .'>' . $result->name . '</a>
                </div>
                ';
             }
             return $sendData;

         }

         if ($request->type == 'shop') {
             $results = Vendor::where('shop_name', 'LIKE', '%'. $request->input .'%')->get();

             $sendData = '';
             foreach($results as $result)
             {
                $sendData .=
                '<tr>
                    <td class="w-20">
                    <a href='. route('vendor.shop',$result->slug) .' class="img-fluid"  alt='.$result->shop_name.'>
                        <img src='.filePath($result->shop_logo).' clas="img-fluid" alt='.$result->shop_name.'>
                    </a>
                    <td>
                    <td class="padding-20">
                    <a href='. route('vendor.shop',$result->slug)  .'>' . $result->shop_name . '</a>
                    </td>
                </tr>
                ';
             }
             return $sendData;
         }
     }

}
