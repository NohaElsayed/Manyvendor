<?php

namespace App\Http\Controllers\backend\admin\campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignProduct;
use App\Models\Cart;
use App\Models\EcomCampaignProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CampaignsController extends Controller
{
    //all campaigns
    public function index()
    {
        $campaigns = Campaign::where('is_requested', NULL)->orderBy('created_at', 'desc')->paginate(paginate());
        return view('backend.campaign.index', compact('campaigns'));
    }

    //campaign create modal
    public function create()
    {
        return view('backend.campaign.create');
    }

    //save campaign
    public function store(Request $request)
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

        $campaign->meta_title = $request->meta_title;
        $campaign->meta_desc = $request->meta_desc;
        if ($request->hasFile('meta_image')) {
            $campaign->meta_image = fileUpload($request->meta_image, 'campaign');
        }

        $campaign->save();
        return back()->with('success', translate('A new campaign has been added.'));
    }

    //campaign edit modal
    public function edit($id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('backend.campaign.edit', compact('campaign'));
    }

    //update campaign
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:campaigns,title,' . $request->id
        ], [
            'title.required' => translate('Campaign title is required'),
            'title.unique' => translate('A campaign with this name already exists')
        ]);

        $campaign = Campaign::where('id', $request->id)->first();
        $campaign->title = $request->title;
        $slug = Str::slug($request->title);

        /*check the slug*/
        $s = Campaign::where('slug', $slug)->get();
        if ($s->count() > 0) {
            $campaign->slug = $slug . '-' . ($s->count());
        } else {
            $campaign->slug = $slug;
        }

        if ($request->hasFile('new_banner')) {
            //delete the banner
            if ($request->banner != null) {
                fileDelete($request->banner);
            }
            //store the new banner
            $campaign->banner = fileUpload($request->new_banner, 'campaign');
        }

        $campaign->offer = $request->offer;
        $campaign->start_from = Carbon::parse($request->start_from);
        $campaign->end_at = Carbon::parse($request->end_at);

        $campaign->meta_title = $request->meta_title;
        $campaign->meta_desc = $request->meta_desc;

        if ($request->hasFile('new_meta_image')) {
            //delete the meta image
            if ($campaign->meta_image != null) {
                fileDelete($campaign->meta_image);
            }
            //store the new meta image
            $campaign->meta_image = fileUpload($request->new_meta_image, 'campaign');
        }

        $campaign->active_for_seller = 1;
        $campaign->active_for_customer = 0;
        $campaign->is_requested = NULL;

        $campaign->save();
        return back()->with('success', translate('Campaign has been updated.'));
    }

    //re-campaign edit modal
    public function reCampaignEdit($id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('backend.campaign.re-campaign', compact('campaign'));
    }

    //re-campaign store data
    public function reCampaignStore(Request $request)
    {
        $campaign = Campaign::where('id', $request->id)->first();
        $campaign->start_from = $request->start_from;
        $campaign->end_at = $request->end_at;

        //deleting previous products of this campaign
        $products = CampaignProduct::where('campaign_id', $request->id)->get();
        if ($products->count() > 0) {
            foreach ($products as $product) {
                $product->forceDelete();
            }
        }

        $ecom_camp_pro = EcomCampaignProduct::where('campaign_id', $request->id)->get();
        if ($ecom_camp_pro->count() > 0) {
            foreach ($ecom_camp_pro as $ecomProduct) {
                $ecomProduct->forceDelete();
            }
        }

        $campaign->save();
        return back()->with('success', translate('Campaign has been started again.'));
    }

    //search campaign
    public function search(Request $request)
    {
        $search = $request->search;
        $campaigns = Campaign::where('title', 'like', '%' . $search . '%')->orWhere('offer', 'like', '%' . $search . '%')->paginate(paginate());
        return view('backend.campaign.index', compact('campaigns'));
    }

    //seller published
    public function sellerPublished(Request $request)
    {
        $campaign = Campaign::where('id', $request->id)->first();
        if ($campaign->active_for_seller == 1) {
            $campaign->active_for_seller = 0;
            $campaign->save();
        } else {
            $campaign->active_for_seller = 1;
            $campaign->save();
        }
        return response(['message' => translate('Campaign\'s status for seller has been changed')], 200);
    }

    //customer published
    public function customerPublished(Request $request)
    {
        $campaign = Campaign::where('id', $request->id)->first();
        if ($campaign->active_for_customer == 1) {
            $campaign->active_for_customer = 0;
            $campaign->save();
        } else {
            $campaign->active_for_customer = 1;
            $campaign->save();
        }
        return response(['message' => translate('Campaign\'s status for customer has been changed')], 200);
    }

    //delete campaign
    public function destroy($id)
    {
        $products = CampaignProduct::where('campaign_id', $id)->get();

        foreach ($products as $product) {
            $product->forceDelete();
        }

        $cart_items = Cart::where('campaign_id', $id)->get();
        foreach ($cart_items as $cart_item) {
            $cart_item->delete();
        }

        Campaign::where('id', $id)->forceDelete();
        return back()->with('success', translate('Campaign has been deleted successfully'));
    }


    //get products to add in campaign (E-commerce)
    public function indexProducts($slug)
    {
        $campaign = Campaign::where('slug', $slug)->first();
        $products = Product::where('is_published', 1)->get();
        $campaign_products = EcomCampaignProduct::all();
        return view('backend.campaign.ecom_products', compact('products', 'campaign', 'campaign_products'));
    }

    //add products to campaign (E-commerce)
    public function productStore(Request $request)
    {
        $campaign = new EcomCampaignProduct;
        $campaign->campaign_id = $request->campaign_id;
        $campaign->product_id = $request->product_id;
        $campaign->save();
        return response(["message" => translate("Added to campaign"), "btn_rmv" => translate('remove')]);
    }

    //delete product from campaign (E-commerce)
    public function productDestroy(Request $request)
    {
        EcomCampaignProduct::where('product_id', $request->product_id)
            ->where('campaign_id', $request->campaign_id)->first()->forceDelete();
        return response(["message" => translate("Removed from campaign"), "btn_add" => translate('Add To Campaign')]);
    }

    //search campaign products (E-commerce)
    public function searchProducts(Request $request)
    {
        $campaign = Campaign::where('slug', $request->slug)->first();
        $products = Product::where('is_published', 1)->where('name', 'like', '%' . $request->search . '%')->get();
        $campaign_products = EcomCampaignProduct::all();
        return view('backend.campaign.ecom_products', compact('products', 'campaign', 'campaign_products'));

    }

}
