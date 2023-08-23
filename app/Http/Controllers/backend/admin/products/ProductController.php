<?php

namespace App\Http\Controllers\backend\admin\products;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Demo;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{


    /*product list*/
    public function index()
    {

        $products = Product::where('is_request', 0)->with('variants')->with('images')->orderByDesc('id')->paginate(paginate());
        $variants = Variant::all();
        return view('backend.products.product.index', compact('products', 'variants'));
    }

    /*requestIndex*/
    public function requestIndex(){
        $requestProducts = Product::where('is_request', 1)->with('variants')->with('images')->orderByDesc('id')->paginate(paginate());
        $variants = Variant::all();
        return view('backend.products.product.index', compact( 'variants', 'requestProducts'));
    }


    /*product create from*/
    public function create()
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
        return view('backend.products.product.create', compact('brands', 'categories', 'variants'));
    }

    /*get child category*/
    public function childIndex(Request $request)
    {
        $childCats = Category::where('parent_category_id', $request->id)->with('commission')->Published()->get();
        $cats = collect();
        foreach ($childCats as $childCat) {
            $demo = new Demo();
            $demo->id = $childCat->id;
            $demo->name = $childCat->name;
            if (vendorActive()){
                if ($childCat->commission) {
                    $demo->commission = ' (' . $childCat->commission->amount . ') % Commission';
                }else{
                    $demo->commission ='';
                }
            }else{
                $demo->commission ='';
            }
            $cats->push($demo);
        }

        return response(['data' => $cats, 'message' => translate('Child category')]);
    }


    /*save the admin product*/
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'parent_id' => 'required',
            'category_id' => 'required',
            'image' => 'required'
        ], [
            'name.required' => translate('Name is required'),
            'parent_id.required' => translate('Parent category is required'),
            'category_id.required' => translate('Category is required'),
            'image.required' => translate('Image is required')
        ]);

            /*slug*/
            $slug = Str::slug($request->name);
            $p = Product::where('slug', $slug)->get();
            if ($p->count() > 0) {
                $slug = $slug . ($p->count() + 1);
            }


            $pro = new Product();
            $pro->name = $request->name;
            $pro->slug = $slug;
            $pro->sku = sku();
            $pro->short_desc = $request->short_desc;
            $pro->big_desc = $request->big_desc;
            $pro->mobile_desc = $request->mobile_desc;
            $pro->brand_id = $request->brand_id;
            $pro->parent_id = $request->parent_id;
            $pro->category_id = $request->category_id;
            $pro->provider = $request->provider;
            $pro->video_url = $request->video_url;
            $pro->meta_title = $request->meta_title;
            $pro->meta_desc = $request->meta_desc;

            //tax added by akash
            $pro->tax = $request->tax ?? 0;


            $data = explode(',', $request->tags);
            $pro_value = array();
            foreach ($data as $item) {
                array_push($pro_value, $item);
            }

            $tags = json_encode($pro_value);
            $pro->tags = $tags;

            
            if ($request->image != null) {
                $pro->image = fileUpload($request->image, $slug);
            }
            if ($request->meta_image != null) {
                $pro->meta_image = fileUpload($request->meta_image, $slug);
            }


            $pro->save();

            /*upload multiple image*/
            if ($request->images) {
                foreach ($request->images as $image) {
                    $proImg = new ProductImage();
                    $proImg->product_id = $pro->id;
                    $proImg->image = fileUpload($image, $slug);
                    $proImg->save();
                }
            }


            
            /*variant of size*/
            if ($request->add_variant == 'on' && !is_null($request->units)) {
                $pro->have_variant = true;
                $pro->save();
                foreach ($request->units as $unit) {
                    foreach ($request->variant_id as $var) {
                        $name = Variant::where('id', $var)->where('unit', $unit)->first();
                        if ($name) {
                            $v = new ProductVariant();
                            $v->variant_id = $var;
                            $v->product_id = $pro->id;
                            $v->unit = $name->unit;
                            $v->save();
                        }
                    }
                }
            }

            /*here if active vendor*/
            if (vendorActive()){
                return back()->with('success', translate('Product has been added successfully'));
            }else{
                /*redirect ecommerce variant product update*/
                $product_update = Product::find($pro->id);
                if ($request->is_discount == 'on') {
                    $product_update->is_discount = true;
                    if ($request->discount_type == 'flat') {
                        $product_update->discount_price = $request->discount_price;
                        $product_update->discount_type = "flat";
                        //if discount is flat
                        $discounted_price = $request->product_price - $request->discount_price;
                        $discount_percentage = ($discounted_price / $request->product_price) * 100;
                        $product_update->discount_percentage = $discount_percentage;
                    } else {
                        $product_update->discount_type = "per";
                        $product_update->discount_percentage = $request->discount_price;
                        $product_update->discount_price = ($request->discount_price * $request->product_price) / 100;
                    }
                } else {
                    $product_update->is_discount = false;
                }
                $product_update->product_price = $request->product_price;
                $product_update->purchase_price = $request->purchase_price;
                $product_update->save();
                Alert::success('info', translate('Manage Stock Now!'));
                return redirect()->route('product.step.tow',[$pro->id,$pro->slug]);
            }
    }


    /*remove product image*/
    public function removeImage($id)
    {
        $i = ProductImage::where('id', $id)->first();
        fileDelete($i->image);
        $i->delete();
        return response(['message' => translate('Image has been removed'), 'id' => $id]);
    }


    /*product edit*/
    public function edit($id, $slug)
    {
        $product = Product::where('id', $id)->where('slug', $slug)->with('images')->with('variants')->first();
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

        return view('backend.products.product.edit', compact('product', 'brands', 'categories', 'variants'));
    }


    /*product update*/
    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'parent_id' => 'required',
            'category_id' => 'required',
            'image' => 'required'
        ], [
            'name.required' => translate('Name is required'),
            'parent_id.required' => translate('Parent category is required'),
            'category_id.required' => translate('Category is required'),
            'image.required' => translate('Image is required')
        ]);
        try {
            $pro = Product::where('id', $request->id)->where('slug', $request->slug)->first();

            $slug = $request->slug;
            /*slug*/
            if ($pro->slug != $slug) {
                $slug = Str::slug($request->name);
                $p = Product::where('slug', $slug)->get();
                if ($p->count() > 0) {
                    $slug = $slug . ($p->count() + 1);
                }
            }

            $pro->name = $request->name;
            $pro->slug = $slug;
            $pro->short_desc = $request->short_desc;
            $pro->big_desc = $request->big_desc;
            $pro->mobile_desc = $request->mobile_desc;
            $pro->brand_id = $request->brand_id;
            $pro->parent_id = $request->parent_id;
            $pro->category_id = $request->category_id;
            $pro->provider = $request->provider;
            $pro->video_url = $request->video_url;
            $pro->meta_title = $request->meta_title;
            $pro->meta_desc = $request->meta_desc;

            //tax added by akash
            $pro->tax = $request->tax;


            $pro->is_request = false;
            if ($request->newImage != null) {
                $pro->image = fileUpload($request->newImage, $slug);
                fileDelete($request->image);
            }

            if ($request->newMetaimage != null) {
                $pro->meta_image = fileUpload($request->newMetaimage, $slug);
                fileDelete($request->meta_image);
            }
            $pro->save();

            /*upload multiple image*/

            if ($request->images != null) {
                foreach ($request->images as $image) {
                    $proImg = new ProductImage();
                    $proImg->product_id = $pro->id;
                    $proImg->image = fileUpload($image, $slug);
                    $proImg->save();
                }
            }

            /*add the variant*/
            if ($request->add_variant != null) {
                foreach ($request->units as $unit) {
                    foreach ($request->variant_id as $var) {
                        /*check this variant has in database*/
                        $has_variant = ProductVariant::where('variant_id', $var)->where('product_id', $pro->id)->first();
                        if ($has_variant == null) {
                            $name = Variant::where('id', $var)->where('unit', $unit)->first();
                            if ($name != null) {
                                $v = new ProductVariant();
                                $v->variant_id = $var;
                                $v->product_id = $pro->id;
                                $v->unit = $name->unit;
                                $v->save();
                            }
                        }
                    }
                }
            }

            /*ecommerce setting implement*/
            if (vendorActive()){
                return back()->with('success', translate('Product updated successfully'));
            }else{
                $product_update = Product::find($pro->id);
                if ($request->is_discount == 'on') {
                    $product_update->is_discount = true;
                    if ($request->discount_type == 'flat') {
                        $product_update->discount_price = $request->discount_price;
                        $product_update->discount_type = "flat";
                        //if discount is flat
                        $discounted_price = $request->product_price - $request->discount_price;
                        $discount_percentage = ($discounted_price / $request->product_price ) * 100;
                        $product_update->discount_percentage = $discount_percentage;
                    } else {
                        $product_update->discount_type = "per";
                        $product_update->discount_percentage = $request->discount_price;
                        $product_update->discount_price = ($request->discount_price * $request->product_price) / 100;
                    }
                } else {
                    $product_update->is_discount = false;
                }
                $product_update->product_price = $request->product_price;
                $product_update->purchase_price = $request->purchase_price;
                $product_update->save();
                Alert::success('info', translate('Manage Stock Now!'));
                return redirect()->route('product.step.tow.edit',[$pro->id,$pro->slug]);
            }

        } catch (\Exception $exception) {
            return back()->with('warning', $exception);
        }

    }


    /*delete product*/
    public function destroy($id)
    {
        try {
            $pro = Product::find($id);
            $pros = ProductVariant::where('product_id', $id)->delete();
            $prosImg = ProductImage::where('product_id', $id)->get();

            //delete images
            foreach ($prosImg as $i) {
                fileDelete($i->image);
            }
            fileDelete($pro->image);
            $pro->delete();
            return back()->with('success', translate('Product deleted successfully'));

        } catch (\Exception $exception) {
            return back()->with('info', translate('There are a problems'));
        }
    }

    // single_product
    public function single_product($sku, $slug)
    {

        $single_product = Product::where('sku', $sku)
            ->where('slug', $slug)
            ->with('images')
            ->with('brand')
            ->with('category')
            ->with('childcategory')
            ->with('sellers')
            ->with('variants')
            ->first();

        //same brand
        $brand_products = Product::where('brand_id', $single_product->brand_id)
            ->with('sellers')
            ->take(2)
            ->get()
            ->shuffle();

        // related products
        $related_products = Product::where('category_id', $single_product->category_id)
            ->with('sellers')
            ->take(9)
            ->get()
            ->shuffle();

        return view('frontend.product.single_product', compact('single_product', 'brand_products', 'related_products'));

    }


    /*active*/
    public function active($id, $slug)
    {
        $product = Product::where('id', $id)->where('slug', $slug)->first();
        $product->is_request = false;
        $product->save();
        return back()->with('success', translate('Product request has been approved'));
    }

    /*published*/
    public function published(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        if ($product->is_published == 1) {
            $product->is_published = 0;
            $product->save();
        } else {
            $product->is_published = 1;
            $product->save();
        }
        return response(['message' => translate('Product status has been changed')], 200);
    }

}
