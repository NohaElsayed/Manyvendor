<?php

namespace App\Http\Controllers\backend\seller\products;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    /*category view*/
    public function catCreate()
    {
        $ids = array();
        $catGroup = Category::Published()->where('parent_category_id', 0)->get();
        foreach ($catGroup as $item) {
            array_push($ids, $item->id);
        }
        $parentCategories = Category::Published()->whereIn('parent_category_id', $ids)->get();
        return view('backend.sellers.products.category_request', compact('parentCategories'));
    }

    /*request category save*/
    public function catStore(Request $request)
    {

        $request->validate([
            'category_id' => 'required',
            'name' => 'required'
        ], [
            'category_id.required' => translate('The parent category must be chosen.'),
            'name.required' => translate('Category name is required.')
        ]);

        $cat = new Category();
        $slug = Str::slug($request->name);
        if ($slug == $request->slug) {
            $cat->slug = $request->slug;
        } else {
            /*check the slug*/
            $c = Category::where('slug', $slug)->get();
            if ($c->count() > 0) {
                $cat->slug = $slug . ($c->count());
            } else {
                $cat->slug = $slug;
            }
        }
        $cat->name = $request->name;
        $cat->parent_category_id = $request->category_id;
        $cat->user_id = Auth::id();

        if (sellerMode()) {
            $cat->is_published = 0;
            $cat->is_requested = 1;
            $cat->save();
            return back()->with('success', translate('Your request for a new category has been successful.'));
        } else {
            $cat->is_published = 1;
            $cat->is_requested = 0;
            $cat->save();
            return back()->with('success', translate('category has been created successfully.'));
        }
    }

}
