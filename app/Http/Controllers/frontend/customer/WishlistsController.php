<?php

namespace App\Http\Controllers\frontend\customer;

use App\Http\Controllers\Controller;
use App\Models\Demo;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class WishlistsController extends Controller
{
    //all wishlist list
    public function indexBlade()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->get();
        $wishlist_list = collect();
        if (vendorActive()){
            foreach ($wishlist as $wishlist_list_item){
                $demo_obj = new Demo;
                $demo_obj->id = $wishlist_list_item->id;

                $demo_obj->image = filePath($wishlist_list_item->product->image);
                $demo_obj->name = $wishlist_list_item->product->name;

                $demo_obj->sku = $wishlist_list_item->product->sku;
                $demo_obj->slug = $wishlist_list_item->product->slug;

                $demo_obj->range = brandProductPrice($wishlist_list_item->product->sellers)->min() != brandProductPrice($wishlist_list_item->product->sellers)->max() ? formatPrice(brandProductPrice($wishlist_list_item->product->sellers)->min()).' - '.formatPrice(brandProductPrice($wishlist_list_item->product->sellers)->max()):formatPrice(brandProductPrice($wishlist_list_item->product->sellers)->min());

                $wishlist_list->push($demo_obj);
            }
        }else{
            foreach ($wishlist as $wishlist_list_item){
                $demo_obj = new Demo;
                $demo_obj->id = $wishlist_list_item->id;

                $demo_obj->image = filePath($wishlist_list_item->product->image);
                $demo_obj->name = $wishlist_list_item->product->name;

                $demo_obj->sku = $wishlist_list_item->product->sku;
                $demo_obj->slug = $wishlist_list_item->product->slug;
                if ($wishlist_list_item->product->is_discount){
                    $demo_obj->range = formatPrice($wishlist_list_item->product->discount_price);
                }else{
                    $demo_obj->range = formatPrice($wishlist_list_item->product->product_price);
                }
                $wishlist_list->push($demo_obj);
            }
        }
        return view('frontend.wishlist.index', compact('wishlist_list'));
    }


    //all wishlist list- ajax
    public function index()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->get();

        if (vendorActive()){
            $wishlist_list = collect();
            foreach ($wishlist as $wishlist_list_item){
                $demo_obj = new Demo;
                $demo_obj->id = $wishlist_list_item->id;

                $demo_obj->image = filePath($wishlist_list_item->product->image);
                $demo_obj->name = $wishlist_list_item->product->name;

                $demo_obj->sku = $wishlist_list_item->product->sku;
                $demo_obj->slug = $wishlist_list_item->product->slug;

                $demo_obj->range = brandProductPrice($wishlist_list_item->product->sellers)->min() != brandProductPrice($wishlist_list_item->product->sellers)->max() ? formatPrice(brandProductPrice($wishlist_list_item->product->sellers)->min()).' - '.formatPrice(brandProductPrice($wishlist_list_item->product->sellers)->max()): formatPrice(brandProductPrice($wishlist_list_item->product->sellers)->min());

                $wishlist_list->push($demo_obj);
            }
        }else{
            $wishlist_list = collect();
            foreach ($wishlist as $wishlist_list_item){
                $demo_obj = new Demo;
                $demo_obj->id = $wishlist_list_item->id;

                $demo_obj->image = filePath($wishlist_list_item->product->image);
                $demo_obj->name = $wishlist_list_item->product->name;

                $demo_obj->sku = $wishlist_list_item->product->sku;
                $demo_obj->slug = $wishlist_list_item->product->slug;
                if ($wishlist_list_item->product->is_discount){
                    $demo_obj->range = formatPrice($wishlist_list_item->product->discount_price);
                }else{
                    $demo_obj->range = formatPrice($wishlist_list_item->product->product_price);
                }
                $wishlist_list->push($demo_obj);
            }
        }

        return response($wishlist_list);
    }


    //add to wishlist
    public function store(Request $request)
    {
        $exist = Wishlist::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();
        if(is_null($exist)){
            $wishlist = new Wishlist;
            $wishlist->user_id = Auth::id();
            $wishlist->product_id = $request->product_id;
            $wishlist->save();
            return response(["message" => translate('Added to wishlist')]);
        }
        else{
            return response(["message" => translate('Already in wishlist')]);
        }
    }


    //delete item from wishlist
    public function destroy(Request $request)
    {
        Wishlist::where('id',$request->id)->forceDelete();
        return response(["message" => translate('Item has been removed from wishlist')]);
    }

    //delete item from wishlist in blade
    public function delete($id)
    {
        Wishlist::findOrFail($id)->forceDelete();
        Alert::success(translate('Done!'), translate('Item has been deleted successfully'));
        return back();
    }
}
