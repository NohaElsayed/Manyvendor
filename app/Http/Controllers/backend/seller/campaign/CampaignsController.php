<?php

namespace App\Http\Controllers\backend\seller\campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignProduct;
use App\Models\Demo;
use App\VendorProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CampaignsController extends Controller
{
    //all campaigns
    public function index()
    {
        //only show campaigns that are not over yet
        $campaigns = Campaign::where('active_for_seller', 1)->where('end_at', '>=', Carbon::now()->format('Y-m-d'))->orderBy('created_at', 'desc')->paginate(paginate());
        return view('backend.sellers.campaign.index', compact('campaigns'));
    }


    //get seller products to add in campaign
    public function indexProducts($slug)
    {
        $campaign = Campaign::where('slug', $slug)->first();
        $products = VendorProduct::where('user_id', Auth::id())->get();

        $products_list = collect();
        foreach ($products as $product) {
            $demo_obj = new Demo;

            $demo_obj->id = $product->id;
            $demo_obj->img = filePath($product->product->image);
            $demo_obj->name = $product->product->name;

            $demo_obj->sku = $product->product->sku;
            $demo_obj->slug = $product->product->slug;

            if (is_null($product->discount_price)) {
                $demo_obj->price = formatPrice($product->product_price);
            } else {
                $demo_obj->price = formatPrice($product->discount_price);
            }

            $products_list->push($demo_obj);
        }

        $campaign_products = CampaignProduct::where('vendor_id', Auth::id())->get();
        return view('backend.sellers.campaign.products', compact('products_list', 'campaign', 'campaign_products'));
    }

    //add products to campaign
    public function store(Request $request)
    {
        $campaign = new CampaignProduct;
        $campaign->campaign_id = $request->campaign_id;
        $campaign->vendor_id = Auth::id();
        $campaign->vendor_product_id = $request->vendor_product_id;
        $campaign->save();
        return response(["message" => translate("Added to campaign"), "btn_rmv" => translate('remove')]);
    }


    //delete product from campaign
    public function destroy(Request $request)
    {
        CampaignProduct::where('vendor_id', Auth::id())->where('vendor_product_id', $request->vendor_product_id)
            ->where('campaign_id', $request->campaign_id)->first()->forceDelete();
        return response(["message" => translate("Removed from campaign"), "btn_add" => translate('Add To Campaign')]);
    }


    //search campaign
    public function search(Request $request)
    {
        $search = $request->search;
        $campaigns = Campaign::where('active_for_seller', 1)->where('end_at', '>=', Carbon::now()->format('Y-m-d'))
            ->where('title', 'like', '%' . $search . '%')->orWhere('offer', 'like', '%' . $search . '%')
            ->orderBy('created_at', 'desc')->paginate(paginate());
        return view('backend.sellers.campaign.index', compact('campaigns'));
    }


    //search products campaign
    public function searchProducts(Request $request)
    {
        $campaign = Campaign::where('slug', $request->slug)->first();
        $products = VendorProduct::where('user_id', Auth::id())->get();

        $products_list = collect();
        foreach ($products as $product) {
            $temp = $product->product->where('name', 'like', '%' . $request->search . '%')->first();
            if (!is_null($temp)) {
                if ($product->product_id == $temp->id) {
                    $demo_obj = new Demo;
                    $demo_obj->id = $product->id;
                    $demo_obj->img = filePath($product->product->image);
                    $demo_obj->name = $product->product->name;

                    $demo_obj->sku = $product->product->sku;
                    $demo_obj->slug = $product->product->slug;

                    if (is_null($product->discount_price)) {
                        $demo_obj->price = formatPrice($product->product_price);
                    } else {
                        $demo_obj->price = formatPrice($product->discount_price);
                    }
                    $products_list->push($demo_obj);
                }
            }
        }
        $campaign_products = CampaignProduct::where('vendor_id', Auth::id())->get();
        return view('backend.sellers.campaign.products', compact('products_list', 'campaign', 'campaign_products'));
    }

    //campaign request modal
    public function create()
    {
        return view('backend.sellers.campaign.create');
    }

    //save campaign
    public function campaignRequest(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:campaigns'
        ], [
            'title.required' => translate('Campaign title is required'),
            'title.unique' => translate('A campaign with this name already exists')
        ]);

        $campaign = new Campaign;
        $campaign->title = $request->title;
        $slug = Str::slug($request->title);

        /*check the slug*/
        $s = Campaign::where('slug', $slug)->get();
        if ($s->count() > 0) {
            $campaign->slug = $slug . '-' . ($s->count());
        } else {
            $campaign->slug = $slug;
        }
        if ($request->hasFile('banner')) {
            $campaign->banner = fileUpload($request->banner, 'campaign');
        }

        $campaign->offer = $request->offer;
        $campaign->start_from = Carbon::parse($request->start_from);
        $campaign->end_at = Carbon::parse($request->end_at);

        $campaign->active_for_customer = 0;
        if (!sellerMode()){
            $campaign->active_for_seller = 1;
            $campaign->is_requested = null;
            $campaign->save();
            return back()->with('success', translate('Campaign has been added'));
        }else{
            $campaign->active_for_seller = 0;
            $campaign->is_requested = 1;
            $campaign->save();
            return back()->with('success', translate('Request submitted to admin'));
        }

    }
}
