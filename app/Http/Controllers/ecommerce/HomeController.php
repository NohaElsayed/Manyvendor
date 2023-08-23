<?php

namespace App\Http\Controllers\ecommerce;

use App\EcomProductVariantStock;
use App\Http\Controllers\Controller;

use App\Models\Product;

use App\ProductVariantStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    //

    /*app active*/
    public function appActive()
    {
        return view('backend.settings.switch_ecommerce');
    }
//productStepTow
    public function productStepTow($id, $slug)
    {
        $product = Product::where('id', $id)->where('slug', $slug)->with('variants')->firstOrFail();
        return view('backend.products.product.ecom_stepTwo', compact('product'));
    }

    /*this is ajax call function*/
    public function productShow(Request $request)
    {
        $product = Product::where('id', $request->id)->with('variants')->firstOrFail();
        $src = filePath($product->image);
        $product_route = route('single.product', [$product->sku, $product->slug]);
        $quantity = translate('Quantity');
        $alert = translate('Alert Quantity');
        $eprice = translate('Extra Price');
        $total_quantity = translate('Total Quantity');
        $details = (string)"<img class='card-img-top m-3 w-75 center-img' src='$src' alt='$product->name'>
        <div class='card-body'>
          <h5 class='card-title'>$product->name</h5>
        </div><div class='card-body'>
          <a href='$product_route' class='card-link btn btn-primary' target='_blank'>View in Page</a>
        </div><div class='row'>";

        /*here implement the variant*/
        if ($product->variants->count() == 0) {

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
            foreach ($product->variants->groupBy('unit') as $pv) {
                $details .= "<input type='hidden' name='variants_unit[]' value='{$pv->first()->unit}'>";
            }
            $details .= " <table class='table table-responsive-sm variant-table'>
                        <tbody  class='variant-append'>
                        <tr  class='variant-modal'>";

            foreach ($product->variants->groupBy('unit') as $pv) {

                $details .= "<td><select class='form-control select2 w-100' name='variants_{$pv->first()->unit}[]'>";
                foreach ($pv as $pr) {
                    $details .= "<option value='{$pr->variant->variant}-{$pr->id}'>{$pr->variant->variant}</option>";
                }
                $details .= "</select></td>";

            }

            $details .= "<td><input name='pv_q[]' type='number' placeholder='$quantity' min='0' class='form-control' ></td>
                           <td><input name='pv_price[]' type='number' placeholder='$eprice' class='form-control' min='0' step='0.01' ></td>
                           <td><input name='pv_alert_quantity[]' type='number' placeholder='$alert' min='0' class='form-control' ></td>
                       <td><button onclick='incrementVariant()' class='btn-default btn btn-sm m-1' type='button'><i class='fa fa-plus-circle text-success'></i></button>
                       <button onclick='deleteTr(this.id)' id=''  class='btn-default btn btn-sm m-1 remove' type='button'><i class='fa fa-minus-circle text-danger'></i></button></td>
                        </tr></tbody></table>";
        }
        return $details;
    }

//productStepTowEdit
    public function productStepTowEdit($id, $slug)
    {
        $product = Product::where('id', $id)->where('slug', $slug)->with('variants')->firstOrFail();
        return view('backend.products.product.ecom_stepTwo_edit', compact('product'));
    }

    /*product save with variant */
    public function productStepTowStore(Request $request)
    {


        $product = Product::where('id', $request->product_id)->where('category_id', $request->category_id)->firstOrFail();

        /*add product variant*/
        if ($request->variants_unit != null) {
            /*here implement the variant product with quantity*/
            $product->have_variant = true;

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
                    $pstock = new EcomProductVariantStock();
                    $pstock->user_id = Auth::id();
                    $pstock->product_id = $product->id;
                    $pstock->product_variants_id = $variantId[$vc];
                    $pstock->product_variants = $variantData[$vc];
                    $pstock->quantity = (int)json_decode(json_encode($request->pv_q))[$vc];
                    $pstock->extra_price = (float)json_decode(json_encode($request->pv_price))[$vc];
                    $pstock->alert_quantity = (int)json_decode(json_encode($request->pv_alert_quantity))[$vc];
                    $pstock->save();
                }
            }

            $product->save();

        } else {
            /*here implement without variant product*/

            $pstock = new EcomProductVariantStock();
            $pstock->user_id = Auth::id();
            $pstock->product_id = $product->id;
            $pstock->quantity = $request->t_quantity;
            $pstock->alert_quantity = $request->alert_quantity;
            $pstock->save();
            /*product save*/
            $product->save();
        }
        Alert::success('Done', translate('Product Create with stock successfully.'));
        return redirect()->route('admin.products.create');
    }

    /*productStepTowUpdate*/
    public function productStepTowUpdate(Request $request)
    {

//return $request;
        $product = Product::findOrFail($request->product_id);
        /*add product variant*/
        if ($request->variants_unit != null) {
            /*here implement the variant product with quantity*/
            $product->have_variant = true;
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
                    $vpvstock = new EcomProductVariantStock();
                    $vpvstock->user_id = Auth::id();
                    $vpvstock->product_id = $product->id;
                    $vpvstock->product_variants_id = $variantId[$vc];
                    $vpvstock->product_variants = $variantData[$vc];
                    $vpvstock->quantity = (int)json_decode(json_encode($request->pv_q))[$vc];
                    $vpvstock->extra_price = (float)json_decode(json_encode($request->pv_price))[$vc];
                    $vpvstock->alert_quantity = (int)json_decode(json_encode($request->pv_alert_quantity))[$vc];
                    $vpvstock->save();
                }
            }
        } else {
            $product->have_variant = false;
            /*here implement without variant product*/
            $pstock = EcomProductVariantStock::where('id', $request->have_vpstock_id)->first();
            $pstock->user_id = Auth::id();
            $pstock->product_id = $product->id;
            $pstock->quantity = $request->total_quantity;
            $pstock->alert_quantity = $request->alert_quantity_s;
            $pstock->save();
        }

        /*old variant save*/
        if ($request->has('have_pv_id') != null) {
            $product->have_variant = true;
            $r = 0;
            foreach ($request->have_pv_id as $oldVariant) {
                $vps = EcomProductVariantStock::where('id', $oldVariant)->first();
                $vps->quantity = (int)$request->have_pv_q[$r];
                $vps->extra_price = (float)$request->have_pv_price[$r];
                $vps->alert_quantity = (int)$request->have_pv_alert_quantity[$r];
                $vps->save();
                $r++;
            }
        }
        $product->save();
        Alert::success('Done', translate('Product Update with stock successfully.'));
        return back();
    }
}
