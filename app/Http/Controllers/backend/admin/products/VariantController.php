<?php

namespace App\Http\Controllers\backend\admin\products;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Variant;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Alert;

class VariantController extends Controller
{

    /*variant list with form*/
    public function index()
    {
        $variants = Variant::where('is_published', 1)->get();
        $variants_request = Variant::where('is_published', 0)->get();
        $edit = false;
        return view('backend.products.variant.index', compact('variants','edit','variants_request'));
    }

    /*variant store*/
    public function store(Request $request)
    {

        $request->validate([
            'unit' => 'required',
            'variant' => 'required'
        ], [
            'unit.required' => translate('Unit is required'),
            'variant.required' => translate('Variant is required')
        ]);
            $var = new Variant();
            $var->unit = $request->unit;
            $var->variant = Str::lower($request->variant);
            $var->code = $request->code;
            $var->is_published = true;
            $var->save();
        return back()->with('success', translate('Variant has been added successfully.'));
    }

    /*edit variant*/
    public function edit($id)
    {
        $var = Variant::findOrFail($id);
        $edit = true;
        $variants = Variant::all();
        return view('backend.products.variant.index', compact('variants','var','edit'));
    }

    /*update the variant*/
    public function update(Request $request)
    {
        $request->validate([
            'unit' => 'required',
            'variant' => 'required'
        ], [
            'unit.required' => translate('Unit is required'),
            'variant.required' => translate('Variant is required')
        ]);

        try {

            $var = Variant::findOrFail($request->id);
            $var->unit = $request->unit;
            $var->variant = Str::lower($request->variant);
            if ($request->unit == 'Size'){
                $var->code = null;
            }else{
                $var->code = $request->code;
            }
            $var->save();
            return back()->with('success', translate('Variant has been updated successfully.'));

        } catch (\Exception $exception) {
            return back()->with('error', translate('Try again.'));
        }
    }

    /*delete variant*/
    public function destroy($id){
        if(ProductVariant::where('variant_id',$id)->count() > 0){
            return back()->with('warning',translate('First Delete Related product data.'));
        }else{
            Variant::where('id', $id)->forceDelete();
        }

        return back()->with('success',translate('Variant has been deleted successfully.'));
    }

    /**
     * New Variation Request
     */

     public function request_create()
     {

        $brands = Brand::Published()->get();
        $catGroup = Category::where('parent_category_id', 0)->Published()->with('frontParentCat')->get();
        $categories = collect();
        foreach ($catGroup as $group) {
            if ($group->frontParentCat->count() > 0) {
                foreach ($group->frontParentCat as $item) {
                    $categories->push($item);
                }
            }
        }

        /*variant show*/
        $variants = Variant::get()->groupBy('unit');

        return view('backend.sellers.products.variation_request', compact('brands', 'categories','variants'));
     }

    /**
     * New Variation Request Store
     */

     public function request_store(Request $request)
     {

        $request->validate([
            'unit' => 'required',
            'variant' => 'required'
        ], [
            'unit.required' => translate('Unit is required'),
            'variant.required' => translate('Variant is required')
        ]);


         $check_exist = Variant::where('variant', $request->variant)
                                ->first();

        if (isset($check_exist)) {
          Alert::success('Exist','This variation exists');
          return back();
        }else {
            $requset_variant = new Variant();
            $requset_variant->unit = $request->unit;
            $requset_variant->variant = Str::lower($request->variant);
            $requset_variant->code = $request->code;

            if(sellerMode()) {
                $requset_variant->is_published = false;
            }else{
                $requset_variant->is_published = true;
            }
            $requset_variant->save();

            /*variant of size*/
            $requset_product_variant = new ProductVariant();
            $requset_product_variant->product_id = $request->product_id;
            $requset_product_variant->variant_id = $requset_variant->id;
            $requset_product_variant->unit = $request->unit;

            if(sellerMode()){
                $requset_product_variant->is_published = false;
                $requset_product_variant->save();
                return back()->with('success',translate('Variation request sent successfully'));
            }else{
                $requset_product_variant->is_published = true;
                return back()->with('success',translate('Variation has been added'));
            }

        }

     }

     /**
     * New Variation Request
     */

     public function variation_approve($id)
     {
            $variation_approve = Variant::where('id', $id)->first();
            $variation_approve->is_published = true;
            $variation_approve->save();

            /*variant of size*/
            $variation_product_approve = ProductVariant::where('variant_id', $id)->first();
            $variation_product_approve->is_published = true;
            $variation_product_approve->save();

            return back()->with('success',translate('Variation request approved.'));  
     }

     public function variation_decline($id)
     {
            Variant::findOrFail($id)->delete();
            ProductVariant::findOrFail($id)->delete();
            return back()->with('success',translate('Variation request declined.'));  
     }

     public function variation_request_edit($id)
     {  
        $variation_request_edit = Variant::where('id',$id)->first();
        $variation_lists = Variant::all();
        return view('backend.sellers.products.variation_request_edit', compact('variation_request_edit','variation_lists'));
     }

     public function variation_request_update(Request $request, $id)
     {  
        $request->validate([
            'unit' => 'required',
            'variant' => 'required'
        ], [
            'unit.required' => translate('Unit is required'),
            'variant.required' => translate('Variant is required')
        ]);


         $check_exists = Variant::where('variant', $request->variant)
                                ->first();
        if (isset($check_exists)) {
          Alert::success('Exist','This variation is exist');
          return back();
        }else {
            $requset_variant_update = Variant::where('id', $id)->first();
            $requset_variant_update->unit = $request->unit;
            $requset_variant_update->variant = Str::lower($request->variant);
            $requset_variant_update->code = $request->code;
            $requset_variant_update->is_published = false;
            $requset_variant_update->save();

            return back()->with('success',translate('Variation update successfully.'));
        }
     }
    // END
}
