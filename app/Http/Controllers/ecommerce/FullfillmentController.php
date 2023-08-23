<?php

namespace App\Http\Controllers\ecommerce;

use App\Http\Controllers\Controller;
use App\Models\EcomOrderProduct;
use App\Models\Logistic;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class FullfillmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fullfillment_orders = EcomOrderProduct::where('status', 'confirmed')->paginate(50);
        $logistics = Logistic::all();
        return view('backend.ecommerce.ff_index',compact('fullfillment_orders','logistics'));
    }




    /**
     * logistic
     */

    public function logistic($logistic)
    {
        $logistics = Logistic::all();
        $logistic_orders = EcomOrderProduct::where('logistic_id', $logistic)->with('logistic')->paginate(50);
        return view('backend.ecommerce.ff_filter', compact('logistic_orders','logistics'));
    }
}
