<?php

namespace App\Http\Controllers\backend\admin\products;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{


    /*category group list*/
    public function catGroupIndex(){
        $categories = Category::where('parent_category_id',0)->with('childrenCategories')->paginate(paginate());
        /*seller request categories*/
        $sellerRequest =Category::where('is_requested',true)->with('parent')->get();
        return view('backend.products.category.index',compact('categories','sellerRequest'));
    }

    /*category group create*/
    public function catGroupCreate(){
        return view('backend.products.category.groupCatCreate');
    }

    /*category group store*/
    public function catGroupStore(Request $request){
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => translate('Category\'s name is required')
        ]);
        $category = new Category();
        $category->name = $request->name;

        $slug = Str::slug($request->name);
        /*check the slug*/
        $c = Category::where('slug', $slug)->get();
        if ($c->count() > 0) {
            $category->slug = $slug . ($c->count());
        } else {
            $category->slug = $slug;
        }
        if ($request->hasFile('image')) {
            $category->image = fileUpload($request->image, 'category');
        }
        $category->icon = $request->icon;
        $category->meta_title = $request->meta_title;
        $category->meta_desc = $request->meta_desc;
        $category->is_published = true;
        $category->user_id = Auth::id();
        $category->save();

        return back()->with('success', translate('Group category has been added successfully'));
    }

    /*category group edit*/
    public function catGroupEdit($id){
        $category =Category::where('id',$id)->where('parent_category_id',0)->firstOrFail();
        return view('backend.products.category.groupCatEdit',compact('category'));
    }

    /*category group update*/
    public function catGroupUpdate(Request $request){
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => translate('Category\'s name is required')
        ]);
        //save or delete the icon
        if ($request->hasFile('newImage')) {
            //delete the icon
            if ($request->image != null) {
                fileDelete($request->image);
            }
            //store the new icons
            //use store function, no more move_uploaded_files
            $imageName = fileUpload($request->file('newImage'), 'category');

        } else {
            $imageName = $request->image;
        }
        $category = Category::find($request->id);
        $category->name = $request->name;

        $slug = Str::slug($request->name);
        if($slug == $request->slug){
            $category->slug = $request->slug;
        }else{
            /*check the slug*/
            $c = Category::where('slug', $slug)->get();
            if ($c->count() > 0) {
                $category->slug = $slug . ($c->count());
            } else {
                $category->slug = $slug;
            }
        }
        $category->image = $imageName;
        $category->icon = $request->icon;
        $category->meta_title = $request->meta_title;
        $category->meta_desc = $request->meta_desc;
        $category->user_id = Auth::id();
        $category->save();
        return back()->with('success', translate('Group category updated successfully done'));
    }

    //group category end


    //parent start
    //show all category and search here
    public function categoryIndex($id,$slug)
    {
        $cat = Category::where('id', $id)->where('slug',$slug)->first();
        $categories =Category::where('parent_category_id',$cat->id)->get();
        return view('backend.products.category.parentIndex', compact('categories','cat'));
    }

    /*parent category create*/
    public function parentCategoryCreate($id,$slug)
    {
        $cat = Category::where('id', $id)->where('slug',$slug)->first();
        return view('backend.products.category.parentCategoryCreate',compact('cat'));
    }


    /*parent category store*/
    public function parentCategoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => translate('Category\'s name is required')
        ]);
        $category = new Category();
        $category->name = $request->name;

        $slug = Str::slug($request->name);
        /*check the slug*/
        $c = Category::where('slug', $slug)->get();
        if ($c->count() > 0) {
            $category->slug = $slug . ($c->count());
        } else {
            $category->slug = $slug;
        }
        if ($request->hasFile('image')) {
            $category->image = fileUpload($request->image, 'category');
        }
        $category->icon = $request->icon;
        $category->meta_title = $request->meta_title;
        $category->meta_desc = $request->meta_desc;
        $category->start_percentage = $request->start_percentage;
        $category->end_percentage = $request->end_percentage;
        $category->start_amount = $request->start_amount;
        $category->end_amount = $request->end_amount;
        $category->parent_category_id = $request->parent_id;
        $category->is_published = true;
        $category->user_id = Auth::id();
        $category->save();

        return back()->with('success', translate('Parent category has been added successfully'));
    }


    /*parent category edit*/
    public function parentCatEdit($id,$parentId)
    {
        try {
            $category = Category::where('id', $id)->where('parent_category_id', $parentId)->first();
            return view('backend.products.category.parentCatEdit', compact('category'));

        } catch (\Exception $exception) {
            return blank()->with('info', translate('Something is not appropriate!'));
        }

    }

    /*parent category update*/
    public function parentCategoryUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => translate('Category\'s name is required')
        ]);
        //save or delete the icon
        if ($request->hasFile('newImage')) {
            //delete the icon
            if ($request->image != null) {
                fileDelete($request->image);
            }
            //store the new icons
            //use store function, no more move_uploaded_files
            $imageName = fileUpload($request->file('newImage'), 'category');

        } else {
            $imageName = $request->image;
        }
        $category = Category::find($request->id);
        $category->name = $request->name;

        $slug = Str::slug($request->name);
        if($slug == $request->slug){
            $category->slug = $request->slug;
        }else{
            /*check the slug*/
            $c = Category::where('slug', $slug)->get();
            if ($c->count() > 0) {
                $category->slug = $slug . ($c->count());
            } else {
                $category->slug = $slug;
            }
        }
        $category->image = $imageName;
        $category->icon = $request->icon;
        $category->meta_title = $request->meta_title;
        $category->meta_desc = $request->meta_desc;
        /*if percentage*/
        $category->start_percentage = $request->start_percentage;
        $category->end_percentage = $request->end_percentage;
        /*if amount*/
        $category->start_amount = $request->start_amount;
        $category->end_amount = $request->end_amount;
        $category->user_id = Auth::id();
        $category->save();
        return back()->with('success', translate('Parent category updated successfully.'));
    }

    /*show child category*/
    public function childCategories($id, $slug)
    {
        try {
            $category = Category::where('id', $id)->where('is_requested',false)->where('slug', $slug)->with('parent')->first();
            $sub_categories = Category::where('parent_category_id', $category->id)->where('is_requested',false)->get();
            return view('backend.products.category.subIndex', compact('category', 'sub_categories'));

        } catch (\Exception $exception) {
            return back()->with('info', translate('Something is not appropriate!'));
        }
    }

    //create sub category model
    public function categoryCreate($id, $slug)
    {
        try {
            $category = Category::where('id', $id)->where('slug', $slug)->with('parent')->first();
            $commissions = Commission::all();
            return view('backend.products.category.create', compact('category', 'commissions'));
        } catch (\Exception $exception) {
            return back()->with('info', translate('Something is not appropriate!'));
        }

    }

    //store the category
    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'id' => 'required'
        ], [
            'name.required' => translate('Category\'s name is required')
        ]);
        $cat = Category::where('id', $request->id)->where('slug', $request->slug)->first();
        if ($cat == null) {
            return back()->with('info', translate('Something is not appropriate!'));
        }
        $category = new Category();
        $category->name = $request->name;

        $slug = Str::slug($request->name);
        /*check the slug*/
        $c = Category::where('slug', $slug)->get();
        if ($c->count() > 0) {
            $category->slug = $slug . ($c->count());
        } else {
            $category->slug = $slug;
        }
        if ($request->hasFile('image')) {
            $category->image = fileUpload($request->image, 'category');
        }
        $category->icon = $request->icon;
        $category->meta_title = $request->meta_title;
        $category->meta_desc = $request->meta_desc;
        $category->parent_category_id = $cat->id;
        $category->commission_id = $request->commission_id;
        $category->is_published = true;
        $category->user_id = Auth::id();
        $category->save();

        return back()->with('success', translate('Category has been added successfully'));
    }

    //edit category model
    public function categoryEdit($id, $slug)
    {
        $category = Category::where('id', $id)->where('slug', $slug)->first();
        $commissions = Commission::all();
        return view('backend.products.category.edit', compact('category', 'commissions'));
    }

    //update the category
    public function categoryUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => translate('Category\'s name is required')
        ]);

        //save or delete the icon
        if ($request->hasFile('newImage')) {
            //delete the icon
            if ($request->image != null) {
                fileDelete($request->image);
            }
            //store the new icons
            //use store function, no more move_uploaded_files
            $imageName = fileUpload($request->file('newImage'), 'category');

        } else {
            $imageName = $request->image;
        }
        $category = Category::where('id', $request->id)->first();
        $category->name = $request->name;
        $slug = Str::slug($request->name);
        if($slug == $request->slug){
            $category->slug = $request->slug;
        }else{
            /*check the slug*/
            $c = Category::where('slug', $slug)->get();
            if ($c->count() > 0) {
                $category->slug = $slug . ($c->count());
            } else {
                $category->slug = $slug;
            }
        }
        $category->image = $imageName;
        $category->icon = $request->icon;
        $category->meta_title = $request->meta_title;
        $category->meta_desc = $request->meta_desc;
        $category->parent_category_id = $request->parent_id;
        $category->commission_id = $request->commission_id;
        $category->is_requested = false;
        $category->user_id = Auth::id();
        $category->save();

        return back()->with('success', translate('Category update successfully'));
    }

    //soft delete the category
    public function categoryDestroy($id)
    {
       $cat = Category::where('id', $id)->firstOrFail();
       if($cat->image){
           fileDelete($cat->image);
       }
       $cat->forceDelete();
       return back()->with('success', translate('Category deleted successfully'));

    }

    //published
    public function categoryPublished(Request $request)
    {
        // don't use this type of variable naming, use $category instead of $cat1
        $cat = Category::where('id', $request->id)->first();
        if ($cat->is_published == 1) {
            $cat->is_published = 0;
            $cat->save();
        } else {
            $cat->is_published = 1;
            $cat->save();
        }
        return response(['message' => translate('Category\'s active status has been changed')], 200);
    }

    // published
    public function categoryPopular(Request $request)
    {
        // don't use this type of variable naming, use $category instead of $cat1
        $cat = Category::where('id', $request->id)->first();
        if ($cat->is_popular == 1) {
            $cat->is_popular = 0;
            $cat->save();
        } else {
            $cat->is_popular = 1;
            $cat->save();
        }
        return response(['message' => translate('Category\'s popular status has been changed')], 200);
    }

    // published
    public function categoryTop(Request $request)
    {
        // don't use this type of variable naming, use $category instead of $cat1
        $cat = Category::where('id', $request->id)->first();
        if ($cat->top == 1) {
            $cat->top = 0;
            $cat->save();
        } else {
            $cat->top = 1;
            $cat->save();
        }
        return response(['message' => translate('Category\'s top status has been changed')], 200);
    }
}
