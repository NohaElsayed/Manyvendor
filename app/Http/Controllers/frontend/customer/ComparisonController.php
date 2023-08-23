<?php

namespace App\Http\Controllers\frontend\customer;

use App\Http\Controllers\Controller;
use App\Models\Demo;
use App\Models\Product;
use Illuminate\Http\Request;

class ComparisonController extends Controller
{
    //all wishlist list
    public function indexBlade(Request $request)
    {
        $products = [];
        foreach (json_decode($request->products[0]) as $product_id){
            $product = Product::where('id', $product_id)->first();
            array_push($products, $product);
        }
        $comparison_list = collect();
        if (vendorActive()){
            foreach ($products as $item){
                $demo_obj = new Demo;
                $demo_obj->id = $item->id;

                $demo_obj->image = $item->image;
                $demo_obj->name = $item->name;
                $demo_obj->brand = $item->brand->name;
                $demo_obj->category = $item->childcategory->name;
                $demo_obj->short_desc = $item->short_desc;
                $demo_obj->big_desc = $item->big_desc;

                $demo_obj->sku = $item->sku;
                $demo_obj->slug = $item->slug;
                $demo_obj->range = brandProductPrice($item->sellers)->min() != brandProductPrice($item->sellers)->max() ? formatPrice(brandProductPrice($item->sellers)->min()).' - '.formatPrice(brandProductPrice($item->sellers)->max()):formatPrice(brandProductPrice($item->sellers)->min());

                $comparison_list->push($demo_obj);
            }
        }else{
            foreach ($products as $item){
                $demo_obj = new Demo;
                $demo_obj->id = $item->id;

                $demo_obj->image = $item->image;
                $demo_obj->name = $item->name;
                $demo_obj->brand = $item->brand->name;
                $demo_obj->category = $item->childcategory->name;
                $demo_obj->short_desc = $item->short_desc;
                $demo_obj->big_desc = $item->big_desc;

                $demo_obj->sku = $item->sku;
                $demo_obj->slug = $item->slug;
                if($item->is_discount){
                    $demo_obj->range = formatPrice($item->discount_price);
                }else{
                    $demo_obj->range = formatPrice($item->product_price);
                }


                $comparison_list->push($demo_obj);
            }
        }

        return view('frontend.comparison.index', compact('comparison_list'));
    }


    //all comparison list- ajax
    public function index(Request $request)
    {
        $products = [];
        if(!is_null($request->products)){
        foreach ($request->products as $product_id){
            $product = Product::where('id', $product_id)->first();
            array_push($products, $product);
        }

        $comparison_list = collect();
        if (vendorActive()){
            foreach ($products as $item){
                $demo_obj = new Demo;
                $demo_obj->id = $item->id;

                $demo_obj->image = $item->image;
                $demo_obj->name = $item->name;

                $demo_obj->sku = $item->sku;
                $demo_obj->slug = $item->slug;
                $demo_obj->range = brandProductPrice($item->sellers)->min() != brandProductPrice($item->sellers)->max() ? formatPrice(brandProductPrice($item->sellers)->min()).' - '.formatPrice(brandProductPrice($item->sellers)->max()):formatPrice(brandProductPrice($item->sellers)->min());

                $comparison_list->push($demo_obj);
            }
        }else{
            foreach ($products as $item){
                $demo_obj = new Demo;
                $demo_obj->id = $item->id;

                $demo_obj->image = $item->image;
                $demo_obj->name = $item->name;
                $demo_obj->brand = $item->brand->name;
                $demo_obj->category = $item->childcategory->name;
                $demo_obj->short_desc = $item->short_desc;
                $demo_obj->big_desc = $item->big_desc;

                $demo_obj->sku = $item->sku;
                $demo_obj->slug = $item->slug;
                if($item->is_discount){
                    $demo_obj->range = formatPrice($item->discount_price);
                }else{
                    $demo_obj->range = formatPrice($item->product_price);
                }


                $comparison_list->push($demo_obj);
            }
        }

            return response($comparison_list);
        }
    }
}
