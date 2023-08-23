<?php

namespace App\Http\Controllers;

use App\Models\infopage;
use App\Models\Page;
use Illuminate\Http\Request;

class InfoPageController extends Controller
{
    /*info page list*/
    public function index(){
        $pages = Page::all();
        $infopages = infopage::with('page')->get();
        return view('backend.common.infopage.index',compact('pages','infopages'));
    }

    /*store info page*/
    public function store(Request $request){
        $info = new infopage();
        $info->section = $request->section;
        $info->icon = $request->icon;
        $info->header =$request->header;
        $info->desc =$request->desc;
        $info->page_id =$request->page_id;
        $info->save();
        return redirect()->back()->with('success', 'Info page created Successfully');
    }

    /*edit view info page*/
    public function edit($id){
        $pages = Page::all();
        $infopage = infopage::where('id',$id)->with('page')->first();
        return view('backend.common.infopage.edit',compact('pages','infopage'));
    }

    /*update*/
    public function update(Request $request){
        $info =  infopage::where('id',$request->id)->first();
        $info->section = $request->section;
        $info->icon = $request->icon;
        $info->header =$request->header;
        $info->desc =$request->desc;
        $info->page_id =$request->page_id;
        $info->save();
        return redirect()->back()->with('success', 'Info page updated Successfully');
    }

    /*delete*/
    public function delete($id){
        $info =infopage::where('id',$id)->first();
        $info->delete();
        return redirect()->back()->with('success', 'Info page deleted Successfully');
    }
}
