<?php

namespace App\Http\Controllers;

use App\EcomProductVariantStock;
use App\Models\Demo;
use App\Models\EcomOrderProduct;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\VendorProductVariantStock;
use App\User;
use App\VendorProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!vendorActive()) {
            /*if ecommerce*/
            $orderProducts = EcomOrderProduct::latest()->with('logistic')->take(8)->get();
            $PStock = EcomProductVariantStock::all();
            $product_stock = collect();
            foreach ($PStock as $vs) {
                if ($vs->quantity < $vs->alert_quantity) {
                    $vp = Product::where('id', $vs->product_id)->first();
                    if ($vp != null) {
                        $demo_obj = new Demo();
                        $demo_obj->name = $vp->name;
                        $demo_obj->quantity = $vs->quantity;
                        $demo_obj->url = route('product.step.tow.edit', [$vp->id, $vp->slug]);
                        if ($vs->quantity == 0) {
                            $demo_obj->stock = translate('Out of stock');
                        } else {
                            $demo_obj->stock = translate('Limited stock');
                        }
                        $product_stock->push($demo_obj);
                    }
                }
            }
            return view('backend.dashboard.ecommerce_dashboard', compact('orderProducts', 'product_stock'));

        }

        $orderProducts = OrderProduct::latest()->take(8)->get();
        $vPStock = VendorProductVariantStock::all();
        $vps = collect();
        foreach ($vPStock as $vs) {
            if ($vs->quantity < $vs->alert_quantity) {
                $vp = VendorProduct::where('id', $vs->vendor_product_id)->with('product')->with('seller')->first();
                if ($vp != null) {
                    $demo_obj = new Demo();
                    $demo_obj->name = $vp->product->name;
                    $demo_obj->shop_name = $vp->seller->shop_name;
                    $demo_obj->quantity = $vs->quantity;
                    $demo_obj->url = route('seller.products.edit', $vs->vendor_product_id);
                    if ($vs->quantity == 0) {
                        $demo_obj->stock = translate('Out of stock');
                    } else {
                        $demo_obj->stock = translate('Limited stock');
                    }
                    $vps->push($demo_obj);
                }
            }
        }

        return view('backend.dashboard.dashboard', compact('orderProducts', 'vps'));
    }


    public function sellerDashboard()
    {
        $orderProducts = OrderProduct::latest()->take(8)->get();
        $vPStock = VendorProductVariantStock::all();
        $vps = collect();
        foreach ($vPStock as $vs) {
            if ($vs->quantity < $vs->alert_quantity) {
                $vp = VendorProduct::where('user_id', Auth::id())->where('id', $vs->vendor_product_id)->with('product')->first();
                if ($vp != null) {
                    $demo_obj = new Demo();
                    $demo_obj->name = $vp->product->name;
                    $demo_obj->shop_name = $vp->seller->shop_name;
                    $demo_obj->quantity = $vs->quantity;
                    $demo_obj->url = route('seller.products.edit', $vs->vendor_product_id);
                    if ($vs->quantity == 0) {
                        $demo_obj->stock = translate('Out of stock');
                    } else {
                        $demo_obj->stock = translate('Limited stock');
                    }
                    $vps->push($demo_obj);
                }
            }
        }

        return view('backend.dashboard.seller_dashboard', compact('vps'));
    }
}
