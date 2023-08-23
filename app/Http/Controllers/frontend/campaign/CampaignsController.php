<?php

namespace App\Http\Controllers\frontend\campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignProduct;
use App\Models\Demo;
use App\Models\VendorProductVariantStock;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    //all campaigns
    public function index()
    {
        $all_campaigns = Campaign::where('active_for_customer',1)->On()->orderBy('start_from','asc')->get();
        $campaigns = collect();
        foreach ($all_campaigns as $single_campaign) {
            $demo_obj = new Demo;
            $demo_obj->slug = $single_campaign->slug;
            $demo_obj->title = $single_campaign->title;
            $demo_obj->banner = filePath($single_campaign->banner);
            $campaigns->push($demo_obj);
        }
        return view('frontend.campaign.index', compact('campaigns'));
    }


    //show campaign products
    public function show($slug)
    {
        $campaign = Campaign::where('slug', $slug)->On()->first();

        if($campaign == null){
            return redirect()->route('customer.campaigns.index')->with('This campaign is not available.');
        }
        //todo get products from relation by creating demo object
        $products = CampaignProduct::where('campaign_id',$campaign->id)->get();

        //modifying product items to show in campaign products list
        $product_list = collect();
        foreach ($products as $product){
            /*campaign product*/
            $pro = $product->campaignProductFromShop->where('id',$product->vendor_product_id)->first();
            if($pro->frontProduct != null){
                $demo_obj = new Demo;
                $demo_obj->id = $product->id;
                $demo_obj->image = filePath($pro->product->image);
                $demo_obj->name = $pro->frontProduct->name;
                $demo_obj->have_variant = $pro->have_variant;
                $demo_obj->vendor_id = $product->vendor_id;
                $demo_obj->vendor_product_id = $product->vendor_product_id;
                $demo_obj->campaign_id = $campaign->id;
                /*check have variant*/
                if (!$demo_obj->have_variant){
                    $demo_obj->vendor_product_variant_stock_id =
                        VendorProductVariantStock::where('user_id',$demo_obj->vendor_id)
                            ->where('vendor_product_id',$demo_obj->vendor_product_id)->first()->id;
                }

                $demo_obj->quantity = $product->quantity;
                $demo_obj->sku = $pro->frontProduct->sku;
                $demo_obj->slug = $pro->frontProduct->slug;

                //TODO take variant boolean, price of product reducing campaign offer %
                if($pro->is_discount  == false){
                    $demo_obj->price = formatPrice($pro->product_price);
                } else{
                    $demo_obj->price = formatPrice($pro->discount_price);
                }
                $demo_obj->shop_name = $product->campaignProductFromShop->user->vendor->shop_name;
                $product_list->push($demo_obj);
            }

        }

        return view('frontend.campaign.products', compact('campaign', 'product_list'));
    }
}
