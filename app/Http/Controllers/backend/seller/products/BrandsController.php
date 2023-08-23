<?php

namespace App\Http\Controllers\backend\seller\products;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandsController extends Controller
{
    //create brand modal
    public function create()
    {
        return view('backend.sellers.products.brand.create');
    }


    //store brand to database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands'
        ], [
            'name.required' => translate('Brand name is required'),
            'name.unique' => translate('A brand with this name already exists')
        ]);

        $brand = new Brand;
        $brand->name = $request->name;

        $slug = Str::slug($request->name);
        /*check the slug*/
        $s = Brand::where('slug', $slug)->get();
        if ($s->count() > 0) {
            $brand->slug = $slug . ($s->count());
        } else {
            $brand->slug = $slug;
        }
        if ($request->hasFile('logo')) {
            $brand->logo = fileUpload($request->logo, 'brand');
        }
        if ($request->hasFile('banner')) {
            $brand->banner = fileUpload($request->banner, 'brand');
        }
        $brand->meta_title = $request->meta_title;
        $brand->meta_desc = $request->meta_desc;

        /*todo::here implementing the seller/freedom mode*/
        if (sellerMode()) {
            $brand->is_published = 0;
            $brand->is_requested = 1;
            $brand->save();
            return back()->with('success', translate('Your request for a new brand has been successful.'));
        } else {
            $brand->is_published = 1;
            $brand->is_requested = 0;
            $brand->save();
            return back()->with('success', translate('Brand has been created successfully.'));
        }
    }
}
