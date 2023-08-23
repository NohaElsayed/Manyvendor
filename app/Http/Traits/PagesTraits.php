<?php


namespace App\Http\Traits;


use App\Models\Page;
use App\Models\PageContent;
use App\Models\PageGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait PagesTraits
{

    /*pages group*/
    public function pageGroupIndex(){
        $pageGroups = PageGroup::with('pages')->get();
        return view('backend.common.page.groupIndex',compact('pageGroups'));
    }

    /*page group create*/
    public function pageGroupStore(Request $request){
        $page_group = new PageGroup();
        $page_group->name = $request->name;
        $page_group->save();
        return back()->with('success',translate('Page Group created successfully'));
    }

    /*page edit page*/
    public function pageGroupEdit($id){
        $page_group = PageGroup::find($id);
        return view('backend.common.page.groupEdit',compact('page_group'));
    }

    /*page update*/
    public function pageGroupUpdate(Request $request){
        $page_group = PageGroup::find($request->id);
        $page_group->name = $request->name;
        $page_group->save();
        return back()->with('success',translate('Page Group Updated successfully'));
    }

    /*page group delete*/
    public function pageGroupDelete($id){
        $page_group = PageGroup::find($id);
        foreach ($page_group->pages as $page) {
            $page->delete();
        }
        $page_group->delete();
        return back()->with('success',translate('Page Group or related page has been deleted successfully'));
    }

    /*page group Active the page content*/
    public function pageGroupPublish(Request $request)
    {
        $content = PageGroup::where('id', $request->id)->firstOrFail();
        if ($content->is_published == 1) {
            $content->is_published = 0;
        } else {
            $content->is_published = 1;
        }
        $content->save();
        return response(['message' => translate('Page Group status has been changed.')], 200);
    }


//all pages
    public function pageIndex()
    {
        $pages = Page::all();
        return view('backend.common.page.index', compact('pages'));
    }

//create form
    public function pageCreate()
    {
        $pageGroups = PageGroup::where('is_published',true)->get();
        return view('backend.common.page.create',compact('pageGroups'));
    }

    //store page
    public function pageStore(Request $request)
    {
        $request->validate([
            'title' => ['required','unique:pages'],
        ], [
            'title.required' => translate('Title is required'),
            'title.unique' => translate('Title is unique'),
        ]);
        $page = new Page();
        $page->title = $request->title;
        $page->page_group_id = $request->page_group_id;
        $page->slug = Str::slug($request->title);
        $page->save();
        return back()->with('success',translate('Page created successfully'));
    }

    /*page Update view*/
    public function pageEdit($id)
    {
        $page = Page::where('id', $id)->firstOrFail();
        $pageGroups = PageGroup::where('is_published',true)->get();
        return view('backend.common.page.edit', compact('page','pageGroups'));
    }


    /*update save*/
    public function pageUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'id' => 'required',
        ], [
            'title.required' => translate('Title is required'),
            'is.required' => translate('Please reload the page'),
        ]);
        $page = Page::where('id', $request->id)->firstOrFail();
        $page->title = $request->title;
        $page->page_group_id = $request->page_group_id;
        $page->slug = Str::slug($request->title);
        $page->save();
        return back()->with('success',translate('Page created successfully'));

    }

    /*Delete the page*/
    public function pageDestroy($id)
    {
        Page::where('id', $id)->delete();
        PageContent::where('page_id', $id)->delete();
        return back()->with('success',translate('Page deleted successfully'));

    }

    /*page ways content */
    public function contentIndex($id)
    {
        $content = PageContent::where('page_id', $id)->get();
        return view('backend.common.page.content.index', compact('content', 'id'));
    }


    /*content create*/
    public function contentCreate($id)
    {
        return view('backend.common.page.content.create', compact('id'));
    }

    /*Content Create*/
    public function contentStore(Request $request)
    {
        $request->validate([
            'page_id' => 'required',
            'body' => 'required',
        ], [
            'page_id.required' => translate('Page is required'),
            'body.required' => translate('Body is required')
        ]);
        $content = new PageContent();
        $content->page_id = $request->page_id;
        $content->title = $request->title;
        $content->body = $request->body;
        $content->save();

        return back()->with('success',translate('Page content created successfully'));
    }

    /*Page Content Edit*/
    public function contentEdit($id)
    {
        $content = PageContent::where('id', $id)->firstOrFail();
        return view('backend.common.page.content.edit', compact('content'));
    }

    /*Content Update*/
    public function contentUpdate(Request $request)
    {
        $request->validate([
            'page_id' => 'required',
            'body' => 'required',
        ], [
            'page_id.required' => translate('Page is required'),
            'body.required' => translate('Body is required'),
        ]);
        $content = PageContent::where('id', $request->id)->firstOrFail();
        $content->page_id = $request->page_id;
        $content->title = $request->title;
        $content->body = filter_var($request->body, FILTER_SANITIZE_SPECIAL_CHARS);
        $content->save();
        return back()->with('success',translate('Page content updated successfully'));
    }

    /*Content Delete*/
    public function contentDestroy($id)
    {
         PageContent::where('id', $id)->delete();
        return back()->with('success',translate('Content deleted successfully'));
    }

    /*Active the page content*/
    public function contentActive(Request $request)
    {
        $content = PageContent::where('id', $request->id)->firstOrFail();
        if ($content->active == 1) {
            $content->active = 0;
        } else {
            $content->active = 1;
        }
        $content->save();
        return response(['message' => translate('Page content status has been changed')], 200);
    }


    /*Active the Page*/
    public function pageActive(Request $request)
    {
        $page = Page::where('id', $request->id)->firstOrFail();
        if ($page->active == 1) {
            $page->active = 0;
        } else {
            $page->active = 1;
        }
        $page->save();
        return response(['message' => translate('Page status has been changed.')], 200);
    }
}
