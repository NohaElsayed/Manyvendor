<?php

namespace App\Http\Controllers\backend\admin\products;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandsController extends Controller
{
    //show all brand
    public function index()
    {
        $brands = Brand::where('is_requested',0)->paginate(10);
        $requested_brands = Brand::where('is_requested',1)->paginate(10);
        return view('backend.products.brand.index', compact('brands','requested_brands'));
    }


    //create brand modal
    public function create()
    {
        return view('backend.products.brand.create');
    }


    //store brand to database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands'
        ], [
            'name.required' => translate('Brand\'s name is required'),
            'name.unique' => translate('A brand with this name already exists')
        ]);
        $brand = new Brand;
        $brand->name = $request->name;


        $slug =Str::slug($request->name);
        /*check the slug*/
        $s = Brand::where('slug',$slug)->get();
        if($s->count() > 0){
            $brand->slug = $slug.'-'.($s->count());
        }else{
            $brand->slug =$slug;
        }
        if($request->hasFile('logo')){
            $brand->logo = fileUpload($request->logo,'brand');
        }
        if($request->hasFile('banner')){
            $brand->banner = fileUpload($request->banner,'brand');
        }
        $brand->meta_title = $request->meta_title;
        $brand->meta_desc = $request->meta_desc;
        $brand->save();

        return back()->with('success',translate('A new brand added.'));
    }



    //edit Brand model
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $brands = Brand::published()->get();
        return view('backend.products.brand.edit', compact('brand', 'brands'));
    }


    //update the brand
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,'.$request->id
        ], [
            'name.required' => translate('Brand\'s name is required'),
            'name.unique' => translate('A brand with this name already exists')
        ]);
        $brand = Brand::where('id',$request->id)->first();

        $brand->name = $request->name;
        $slug =Str::slug($request->name);
        /*check the slug*/
        $s = Brand::where('slug',$slug)->get();
        if($s->count() > 0){
            $brand->slug = $slug.'-'.($s->count());
        }else{
            $brand->slug =$slug;
        }

        if($request->hasFile('new_logo')){
            //delete the logo
            if ($request->logo != null) {
                fileDelete($request->logo);
            }
            //store the new logo
            $brand->logo = fileUpload($request->new_logo,'brand');
        }

        if($request->hasFile('new_banner')){
            //delete the logo
            if ($request->banner != null) {
                fileDelete($request->banner);
            }
            //store the new logo
            $brand->banner = fileUpload($request->new_banner,'brand');
        }
        $brand->meta_title = $request->meta_title;
        $brand->meta_desc = $request->meta_desc;
        $brand->save();

        return back()->with('success',translate('Brand has been updated successfully.'));
    }



    //delete the brand
    public function destroy($id)
    {
        $products = Product::where('brand_id', $id)->get()->count();
        if($products > 0){
            return back()->with('warning',translate('Delete related products first!'));
        }
        else{
            Brand::where('id', $id)->forceDelete();
            return back()->with('success',translate('Brand has been deleted successfully'));
        }
    }



    //Search in Published brands
    public function searchPublished(Request $request)
    {
        $search = $request->searchPublished;
        $brands = Brand::where('is_requested',0)->where('name', 'like', '%' . $search . '%')->paginate(10);

        $requested_brands = Brand::where('is_requested',1)->paginate(10);
        return view('backend.products.brand.index', compact('brands','requested_brands'));
    }



    //Search in unpublished brands
    public function searchUnpublished(Request $request)
    {
        $brands = Brand::where('is_requested',0)->paginate(10);
        $search = $request->searchUnpublished;
        $requested_brands = Brand::where('is_requested',1)->where('name', 'like', '%' . $search . '%')->paginate(10);
        return view('backend.products.brand.index', compact('brands','requested_brands'));
    }


    //approve requested brand
    public function approve($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->is_published = 1;
        $brand->is_requested = 0;
        $brand->save();
        return back()->with('success',translate('Brand has been approved'));
    }


    //brand published
    public function brandPublished(Request $request)
    {
        $brand = Brand::where('id', $request->id)->first();
        if ($brand->is_published == 1) {
            $brand->is_published = 0;
            $brand->save();
        } else {
            $brand->is_published = 1;
            $brand->save();
        }
        return response(['message' => translate('Brand\'s status has been changed')], 200);
    }

}
