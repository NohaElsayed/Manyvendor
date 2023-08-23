<?php

namespace App\Http\Controllers\backend\admin\products;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    /*commission list and create form*/
    public function index()
    {
        $commissions = Commission::Paginate(paginate());
        return view('backend.products.commission.index', compact('commissions'));
    }

    /*save the commission*/
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'type' => 'required'
        ], [
            'amount.required' => translate('Amount is required'),
            'type.required' => translate('Commission type is required')
        ]);

        $commission = new Commission();
        $commission->amount = $request->amount;
        $commission->type = $request->type;
        $commission->start_amount = $request->start_amount;
        $commission->end_amount = $request->end_amount;
        $commission->save();
        return back()->with('success', translate('Commission has been added successfully'));
    }

    /*edit commission*/
    public function edit($id)
    {
        $commission = Commission::findOrFail($id);
        return view('backend.products.commission.edit', compact('commission'));
    }

    /*commission update*/
    public function update(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'type' => 'required',
            'id' => 'required'
        ], [
            'amount.required' => translate('Amount is required'),
            'type.required' => translate('Commission type is required')
        ]);

        $commission = Commission::findOrFail($request->id);
        $commission->amount = $request->amount;
        $commission->type = $request->type;
        $commission->start_amount = $request->start_amount;
        $commission->end_amount = $request->end_amount;
        $commission->save();
        return back()->with('success', translate('Commission has been updated successfully'));
    }

    /*commission delete*/
    public function destroy($id)
    {
        if (Category::where('commission_id', $id)->count() > 0) {
            return back()->with('warning', translate('Deleted Related Category'));
        }
        Commission::where('id', $id)->forceDelete();
        return back()->with('success', translate('Commission deleted successfully'));
    }
}
