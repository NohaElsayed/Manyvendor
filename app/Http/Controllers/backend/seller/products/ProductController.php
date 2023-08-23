<?php

namespace App\Http\Controllers\backend\seller\products;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Variant;
use App\Models\VendorProductVariantStock;
use App\VendorProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{

    /*vendor product list*/
    public function index()
    {
        $products = VendorProduct::with('product')
            ->with('parentCat')
            ->with('category')
            ->with('variants')
            ->where('user_id', Auth::id())->orderByDesc('id')->paginate(paginate());
        return view('backend.sellers.products.product_index', compact('products'));
    }

    // seller product upload
    public function seller_product_upload()
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
        $variants = Variant::all();
        return view('backend.sellers.products.product_upload', compact('brands', 'categories', 'variants'));
    }

    // Seller product upload
    public function seller_product_store(Request $request)
    {
        $check_exist = VendorProduct::where('product_id', $request->product_id)
            ->where('user_id', Auth::user()->id)
            ->first();
        try {
            if ($check_exist) {
                Alert::success('Exist', 'Product already exists.');
                return back();
            } else {
                $seller_product_upload = new VendorProduct();
                $seller_product_upload->user_id = Auth::id();
                $seller_product_upload->parent_id = $request->parent_id;
                $seller_product_upload->category_id = $request->category_id;
                $seller_product_upload->product_id = $request->product_id;
                $seller_product_upload->product_price = $request->product_price;

                if ($request->is_discount == 'on') {
                    $seller_product_upload->is_discount = true;
                    if ($request->discount_type == 'flat') {
                        $seller_product_upload->discount_price = $request->discount_price;
                        $seller_product_upload->discount_type = "flat";
                        //if discount is flat
                        $discount_percentage = ($request->discount_price * 100) / $request->product_price;
                        $seller_product_upload->discount_percentage = $discount_percentage;
                    } else {
                        $seller_product_upload->discount_type = "per";
                        $seller_product_upload->discount_percentage = $request->discount_price;
                        $seller_product_upload->discount_price = ($request->discount_price * $request->product_price) / 100;
                    }
                } else {
                    $seller_product_upload->is_discount = false;
                    $seller_product_upload->discount_price = NULL;
                }
                $seller_product_upload->purchase_price = $request->purchase_price;
                $seller_product_upload->save();

                /*add product variant*/
                if ($request->variants_unit != null) {
                    /*here implement the variant product with quantity*/
                    $seller_product_upload->have_variant = true;

                    $variantCount = array();
                    /*get the variant unit*/
                    $i = 0;
                    foreach ($request->variants_unit as $pvunit) {
                        if ($request->variants . '_' . $pvunit != null) {
                            $variants = 'variants_' . $pvunit;
                            foreach ($request->$variants as $countVariant) {
                                array_push($variantCount, $i++);
                            }
                        }
                        break;
                    }

                    /*variants variable array */
                    $variantsVar = array();
                    foreach ($request->variants_unit as $pvunit) {
                        $variants = 'variants_' . $pvunit;
                        array_push($variantsVar, $variants);
                    }

                    /*here the variant create loop by count */
                    $variantData = array();
                    $variantId = array();
                    foreach ($variantCount as $vc) {
                        $data = "";
                        $id = "";
                        foreach ($variantsVar as $vvr) {
                            $vvalue = json_decode(json_encode($request->$vvr))[$vc];
                            $data_array = explode('-', $vvalue);
                            $data .= $data_array[0] . '-';
                            $id .= $data_array[1] . '-';

                        }
                        array_push($variantData, substr($data, 0, -1));
                        array_push($variantId, substr($id, 0, -1));

                    }

                    /*save data with variant with stack*/
                    foreach ($variantCount as $vc) {
                        if ((int)json_decode(json_encode($request->pv_q))[$vc] > 0) {
                            $vpvstock = new VendorProductVariantStock();
                            $vpvstock->user_id = Auth::id();
                            $vpvstock->vendor_product_id = $seller_product_upload->id;
                            $vpvstock->product_id = $seller_product_upload->product_id;
                            $vpvstock->product_variants_id = $variantId[$vc];
                            $vpvstock->product_variants = $variantData[$vc];
                            $vpvstock->quantity = (int)json_decode(json_encode($request->pv_q))[$vc];
                            $vpvstock->extra_price = (float)json_decode(json_encode($request->pv_price))[$vc];
                            $vpvstock->alert_quantity = (int)json_decode(json_encode($request->pv_alert_quantity))[$vc];
                            $vpvstock->save();
                        }
                    }

                    /*add total stock*/
                    $vpstock = VendorProductVariantStock::where('vendor_product_id', $seller_product_upload->id)->get();
                    $seller_product_upload->stock = $vpstock->sum('quantity');
                    $seller_product_upload->save();

                } else {
                    /*here implement without variant product*/

                    $vpvstock = new VendorProductVariantStock();
                    $vpvstock->user_id = Auth::id();
                    $vpvstock->vendor_product_id = $seller_product_upload->id;
                    $vpvstock->product_id = $seller_product_upload->product_id;
                    $vpvstock->quantity = $request->t_quantity;
                    $vpvstock->alert_quantity = $request->alert_quantity;
                    $vpvstock->save();
                    $seller_product_upload->stock = $request->t_quantity;
                    $seller_product_upload->save();
                }
                Alert::success('Done', translate('Product uploaded successfully.'));
                return back();
            }

        } catch (\Exception $exception) {
            Alert::warning('Problem', translate('Something is not appropriate! Try again.'));
            return back();
        }
    }

    /*get product details*/
    public function productShow(Request $request)
    {
        $product_show = Product::where('id', $request->id)->with('variants')->first();

        $src = filePath($product_show->image);
        $product_route = route('single.product', [$product_show->sku, $product_show->slug]);
        $quantity = translate('Quantity');
        $alert = translate('Alert Quantity');
        $eprice = translate('Extra Price');
        $total_quantity = translate('Total Quantity');
        $details = (string)"<img class='card-img-top m-3 h-auto w-25' src='$src' alt='$product_show->name'>
        <div class='card-body'>
          <h5 class='card-title'>$product_show->name</h5>
        </div><div class='card-body'>
          <a href='$product_route' class='card-link btn btn-primary' target='_blank'>View in Page</a>
        </div><div class='row'>";

      
            

            /*here implement the variant*/
        if ($product_show->variants->count() == 0) {

            $details .= "<div class='row m-2'><div class='form-group col-6'>
                            <label>$total_quantity</label>
                                <input name='t_quantity' type='number' min='0' placeholder='$total_quantity'
                                       class='form-control'>

                        </div>";
            $details .= "<div class='form-group col-6'>
                            <label>$alert</label>
                                <input name='alert_quantity' min='0' name='a_quantity' type='number' placeholder='$alert'
                                       class='form-control' >

                        </div></div></div>";
        } else {
            /*first loop*/
            foreach ($product_show->variants->groupBy('unit') as $pv) {
                $details .= "<input type='hidden' name='variants_unit[]' value='{$pv->first()->unit}'>";
            }
            $details .= " <table class='table table-responsive-sm variant-table'>
                        <tbody  class='variant-append'>
                        <tr  class='variant-modal'>";

            foreach ($product_show->variants->groupBy('unit') as $pv) {

                $details .= "<td><select class='form-control select2 w-100' name='variants_{$pv->first()->unit}[]'>";
                foreach ($pv as $pr) {
                    $details .= "<option value='{$pr->variant->variant}-{$pr->id}'>{$pr->variant->variant}</option>";
                }
                $details .= "</select></td>";

            }

            $details .= "<td><input name='pv_q[]' type='number' placeholder='$quantity' min='0' class='form-control'></td>
                           <td><input name='pv_price[]' type='number' placeholder='$eprice' class='form-control' min='0' step='0.01'></td>
                           <td><input name='pv_alert_quantity[]' type='number' placeholder='$alert' min='0' class='form-control'></td>
                       <td><button onclick='incrementVariant()' class='btn-default btn btn-sm m-1' type='button'><i class='fa fa-plus-circle text-success'></i></button>
                       <button onclick='deleteTr(this.id)' id=''  class='btn-default btn btn-sm m-1 remove' type='button'><i class='fa fa-minus-circle text-danger'></i></button></td>
                        </tr></tbody></table>";
        }

        /*implement the variant::END*/

        return $details;

    }


    /*get child category product*/
    public function productIndex(Request $request)
    {
        $products = Product::where('category_id', $request->id)->where('is_published', true)->get();
        $items = '';
        foreach ($products as $product) {
            $items .= "<option value=''>" . translate('Select category') . "</option><option value='$product->id'>$product->name</option>";
        }
        return $items;
    }


    /*product request*/
    public function request()
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
        return view('backend.sellers.products.product_request', compact('brands', 'categories', 'variants'));
    }

    /*request store*/
    public function requestStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parent_id' => 'required',
            'category_id' => 'required',
            'image' => 'required'
        ], [
            'name.required' => translate('Name is required.'),
            'parent_id.required' => translate('Category is required.'),
            'category_id.required' => translate('Category is required.'),
            'image.required' => translate('Image is required.')
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
        $pro->brand_id = $request->brand_id;
        $pro->parent_id = $request->parent_id;
        $pro->category_id = $request->category_id;
        $pro->provider = $request->provider;
        $pro->video_url = $request->video_url;
        $pro->meta_title = $request->meta_title;
        $pro->meta_desc = $request->meta_desc;
        if (sellerMode()) {
            $pro->is_request = true;
        }


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


        /*todo:there have complex natok with variant*/
        /*variant of size*/
        if ($request->add_variant != null && !is_null($request->units)) {
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
        } else {
            if(sellerMode()){
                $pro->is_published = false;
                $pro->save();
                return back()->with('success', translate('Product request has been submitted. You didn\'t choose any variant.'));
            }else{
                return back()->with('success', translate('Product has been added. You didn\'t choose any variant.'));
            }
        }
        if(sellerMode()){
            $pro->is_published = false;
            return back()->with('success', translate('Product request has been submitted.'));
        }else{
            return back()->with('success', translate('Product has been added. You didn\'t choose any variant.'));
        }
    }

    /*published*/
    public function published(Request $request)
    {
        $pro = VendorProduct::find($request->id);
        if ($pro->is_published == 1) {
            $pro->is_published = 0;
            $pro->save();
        } else {
            $pro->is_published = 1;
            $pro->save();
        }

        $products = VendorProductVariantStock::where('vendor_product_id', $request->id)->get();

        foreach ($products as $product) {
            if ($product->is_published == 1) {
                $product->is_published = 0;
                $product->save();
            } else {
                $product->is_published = 1;
                $product->save();
            }
        }

        return response(['message' => translate('Product\'s status has been changed')], 200);
    }

    /*vendor product edit*/
    public function edit($id)
    {
        $product = VendorProduct::with('product')
            ->with('parentCat')
            ->with('category')
            ->with('variantProductStock')
            ->where('user_id', Auth::id())->where('id', $id)->firstOrFail();

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
        $variants = Variant::all();
        /*in view pass product id and show product details using data */
        return view('backend.sellers.products.seller_product_edit', compact('product', 'brands', 'categories', 'variants'));
    }


    //Seller product update
    public function seller_product_update(Request $request)
    {
        $seller_product_upload = VendorProduct::where('id', $request->vendor_product_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        try {
            $seller_product_upload->product_price = $request->product_price;
            if ($request->is_discount == 'on') {
                $seller_product_upload->is_discount = true;
                if ($request->discount_type == 'flat') {
                    $seller_product_upload->discount_price = $request->discount_price;
                    $seller_product_upload->discount_type = "flat";
                    //if discount is flat
                    $discount_percentage = ($request->discount_price * 100) / $request->product_price;
                    $seller_product_upload->discount_percentage = $discount_percentage;
                } else {
                    $seller_product_upload->discount_type = "per";
                    $seller_product_upload->discount_percentage = $request->discount_price;
                    $seller_product_upload->discount_price = ($request->discount_price * $request->product_price) / 100;
                }
            } else {
                $seller_product_upload->is_discount = false;
                $seller_product_upload->discount_price = NULL;
            }
            $seller_product_upload->save();

            /*add product variant*/
            if ($request->variants_unit != null) {
                /*here implement the variant product with quantity*/
                $seller_product_upload->have_variant = true;

                $variantCount = array();
                /*get the variant unit*/
                $i = 0;
                foreach ($request->variants_unit as $pvunit) {
                    if ($request->variants . '_' . $pvunit != null) {
                        $variants = 'variants_' . $pvunit;
                        foreach ($request->$variants as $countVariant) {
                            array_push($variantCount, $i++);
                        }
                    }
                    break;
                }

                /*variants variable array */ /*there are problem */
                $variantsVar = array();
                foreach ($request->variants_unit as $pvunit) {
                    $variants = 'variants_' . $pvunit;
                    array_push($variantsVar, $variants);
                }

                /*here the variant create loop by count */
                $variantData = array();
                $variantId = array();
                foreach ($variantCount as $vc) {
                    $data = "";
                    $id = "";
                    foreach ($variantsVar as $vvr) {
                        $vvalue = json_decode(json_encode($request->$vvr))[$vc];
                        $data_array = explode('-', $vvalue);
                        $data .= $data_array[0] . '-';
                        $id .= $data_array[1] . '-';

                    }
                    array_push($variantData, substr($data, 0, -1));
                    array_push($variantId, substr($id, 0, -1));

                }

                /*save data with variant with stock*/
                foreach ($variantCount as $vc) {
                    if ((int)json_decode(json_encode($request->pv_q))[$vc] > 0) {
                        $vpvstock = new VendorProductVariantStock();
                        $vpvstock->user_id = Auth::id();
                        $vpvstock->vendor_product_id = $seller_product_upload->id;
                        $vpvstock->product_id = $seller_product_upload->product_id;
                        $vpvstock->product_variants_id = $variantId[$vc];
                        $vpvstock->product_variants = $variantData[$vc];
                        $vpvstock->quantity = (int)json_decode(json_encode($request->pv_q))[$vc];
                        $vpvstock->extra_price = (float)json_decode(json_encode($request->pv_price))[$vc];
                        $vpvstock->alert_quantity = (int)json_decode(json_encode($request->pv_alert_quantity))[$vc];
                        $vpvstock->save();
                    }
                }

                /*add total stock*/
                $vpstock = VendorProductVariantStock::where('vendor_product_id', $seller_product_upload->id)->get();
                $seller_product_upload->stock = $vpstock->sum('quantity');
                $seller_product_upload->save();

            } else {
                /*here implement without variant product*/
                $vpvstock = VendorProductVariantStock::where('id', $request->have_vpstock_id)->first();
                $vpvstock->user_id = Auth::id();
                $vpvstock->vendor_product_id = $seller_product_upload->id;
                $vpvstock->product_id = $seller_product_upload->product_id;
                $vpvstock->quantity = $request->t_quantity;
                $vpvstock->alert_quantity = $request->alert_quantity;
                $vpvstock->save();
                $seller_product_upload->stock = $request->t_quantity;
                $seller_product_upload->save();
            }

            /*old variant save*/
            if ($request->has('have_pv_id') != null) {
                $r = 0;
                foreach ($request->have_pv_id as $oldVariant) {
                    $vps = VendorProductVariantStock::where('id', $oldVariant)->first();
                    $vps->quantity = (int)$request->have_pv_q[$r];
                    $vps->extra_price = (float)$request->have_pv_price[$r];
                    $vps->alert_quantity = (int)$request->have_pv_alert_quantity[$r];
                    $vps->save();
                    $r++;
                }
            }
            Alert::success('Done', translate('Product has been uploaded successfully.'));
            return back();

        } catch (\Exception $exception) {
            Alert::warning('Problem', translate('Something is not appropriate! Try again.' . $exception));
            return back();
        }
    }
}
