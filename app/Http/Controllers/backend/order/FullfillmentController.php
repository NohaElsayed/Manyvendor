<?php

namespace App\Http\Controllers\backend\order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Notification;
use Auth;
use Alert;
use App\User;
use App\Models\OrderProduct;
use App\Models\Logistic;
use App\Notifications\OrderNotification;

class FullfillmentController extends Controller
{
    /*fullfillment index*/
    public function index()
    {
        $fullfillment_orders = OrderProduct::where('status', 'confirmed')->paginate(50);
        $logistics = Logistic::all();
        return view('backend.fullfillment.index', compact('fullfillment_orders', 'logistics'));
    }


    /*fullfullment filter*/
    public function logistic($logistic)
    {
        $logistics = Logistic::all();
        $logistic_orders = OrderProduct::where('logistic_id', $logistic)->with('logistic')->paginate(50);
        return view('backend.fullfillment.filter', compact('logistic_orders', 'logistics'));
    }

    //END
}
