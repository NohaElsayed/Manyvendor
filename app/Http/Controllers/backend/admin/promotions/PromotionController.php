<?php

namespace App\Http\Controllers\backend\admin\promotions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Promotion;
use Alert;

class PromotionController extends Controller
{


    // Category Banner
    public function categoryPromotion()
    {
        $categories = Category::Published()->where('parent_category_id', 0)->get();
        return view('backend.promotions.categories.index', compact('categories'));
    }

    // categoryPromotionStore
    public function categoryPromotionStore(Request $request)
    {
        $category = new Promotion();
        $category->category_id = $request->category_id;
        $category->link = $request->link;
        $category->type = 'category';

        if ($request->hasFile('image')) {
            $category->image = fileUpload($request->image, 'promotions/categories');
        }

        if ($request->is_published == 'on') {
            $category->is_published = true;
        } else {
            $category->is_published = false;
        }

        $category->save();

        Alert::success(translate('Done'), translate('Added Successfully'));
        return back();
    }


    // categoryPromotionUpdate
    public function categoryPromotionUpdate(Request $request, $id)
    {
        $section_banner_edit = Promotion::findOrFail($id);
        $section_banner_edit->category_id = $request->category_id;
        $section_banner_edit->link = $request->link;
        $section_banner_edit->type = 'category';

        if ($request->hasFile('image')) {
            $section_banner_edit->image = fileUpload($request->image, 'promotions/category');
        } else {
            $section_banner_edit->image = $request->oldImage;
        }

        if ($request->is_published == 'on') {
            $section_banner_edit->is_published = true;
        } else {
            $section_banner_edit->is_published = false;
        }

        $section_banner_edit->save();

        Alert::success(translate('Done'), translate('Updated Successfully'));
        return back();
    }


    // categoryPromotionEdit
    public function categoryPromotionEdit($id)
    {
        $categories = Category::Published()->where('parent_category_id', 0)->get();
        $category_promotion_edit = Promotion::findOrFail($id);
        return view('backend.promotions.categories.edit', compact('categories', 'category_promotion_edit'));
    }


    /**
     * MAIN SLIDER
     */

    // main_slider
    public function main_slider()
    {
        $categories = Category::Published()->where('parent_category_id', 0)->get();
        return view('backend.promotions.main_slider.index', compact('categories'));
    }

    // main_slider_store
    public function main_slider_store(Request $request)
    {
        $main_slider = new Promotion();
        $main_slider->category_id = $request->category_id;
        $main_slider->link = $request->link;
        $main_slider->type = 'mainSlider';

        if ($request->hasFile('image')) {
            $main_slider->image = fileUpload($request->image, 'promotions/main_sliders');
        }

        if ($request->is_published == 'on') {
            $main_slider->is_published = true;
        } else {
            $main_slider->is_published = false;
        }

        $main_slider->save();

        Alert::success(translate('Done'), translate('Added Successfully'));
        return back();
    }


    // main_slider_edit
    public function main_slider_edit($id)
    {
        $categories = Category::Published()->where('parent_category_id', 0)->get();
        $main_slider_edit = Promotion::findOrFail($id);
        return view('backend.promotions.main_slider.edit', compact('categories', 'main_slider_edit'));
    }

    // main_slider_edit
    public function main_slider_update(Request $request, $id)
    {
        $section_banner_edit = Promotion::findOrFail($id);
        $section_banner_edit->category_id = $request->category_id;
        $section_banner_edit->link = $request->link;
        $section_banner_edit->type = 'mainSlider';

        if ($request->hasFile('image')) {
            $section_banner_edit->image = fileUpload($request->image, 'promotions/main_sliders');
        } else {
            $section_banner_edit->image = $request->oldImage;
        }

        if ($request->is_published == 'on') {
            $section_banner_edit->is_published = true;
        } else {
            $section_banner_edit->is_published = false;
        }

        $section_banner_edit->save();

        Alert::success(translate('Done'), translate('Updated Successfully'));
        return back();
    }

    public function categoryPromotionDelete($id)
    {
        Category::findOrFail($id)->delete();
        Alert::toast('Trashed','success');
        return back();
    }


    // section_banner
    public function section_banner()
    {
        $categories = Category::Published()->where('parent_category_id', 0)->get();
        return view('backend.promotions.section_banner.index', compact('categories'));
    }


    // section_banner_store
    public function section_banner_store(Request $request)
    {
        $section_banner = new Promotion();
        $section_banner->category_id = $request->category_id;
        $section_banner->link = $request->link;
        $section_banner->type = 'section';

        if ($request->hasFile('image')) {
            $section_banner->image = fileUpload($request->image, 'promotions/section_banners');
        }

        if ($request->is_published == 'on') {
            $section_banner->is_published = true;
        } else {
            $section_banner->is_published = false;
        }

        $section_banner->save();

        Alert::success(translate('Done'), translate('Added Successfully'));
        return back();
    }

    public function section_banner_edit($id){
        $categories = Category::Published()->where('parent_category_id', 0)->get();
        $section_banner_edit = Promotion::findOrFail($id);
        return view('backend.promotions.section_banner.edit', compact('categories', 'section_banner_edit'));
    }



    // section_banner_update
    public function section_banner_update(Request $request, $id)
    {
        $section_banner_edit = Promotion::findOrFail($id);
        $section_banner_edit->category_id = $request->category_id;
        $section_banner_edit->link = $request->link;
        $section_banner_edit->type = 'section';

        if ($request->hasFile('image')) {
            $section_banner_edit->image = fileUpload($request->image, 'promotions/section_banners');
        } else {
            $section_banner_edit->image = $request->oldImage;
        }

        if ($request->is_published == 'on') {
            $section_banner_edit->is_published = true;
        } else {
            $section_banner_edit->is_published = false;
        }

        $section_banner_edit->save();

        Alert::success(translate('Done'), translate('Updated Successfully'));
        return back();
    }


    // header_banner
    public function header_banner()
    {
        $categories = Category::Published()->where('parent_category_id', 0)->get();
        return view('backend.promotions.header_category.index', compact('categories'));
    }


    // header_banner_store
    public function header_banner_store(Request $request)
    {
        $section_banner = new Promotion();
        $section_banner->category_id = $request->category_id;
        $section_banner->link = $request->link;
        $section_banner->type = 'header';

        if ($request->hasFile('image')) {
            $section_banner->image = fileUpload($request->image, 'promotions/header_categories');
        }

        if ($request->is_published == 'on') {
            $section_banner->is_published = true;
        } else {
            $section_banner->is_published = false;
        }

        $section_banner->save();

        Alert::success(translate('Done'), translate('Added Successfully'));
        return back();
    }

    // header_banner_edit
    public function header_banner_edit($id)
    {
        $categories = Category::Published()->where('parent_category_id', 0)->get();
        $header_banner_edit = Promotion::findOrFail($id);
        return view('backend.promotions.header_category.edit', compact('categories', 'header_banner_edit'));
    }

    // header_banner_update
    public function header_banner_update(Request $request, $id)
    {
        $section_banner_edit = Promotion::findOrFail($id);
        $section_banner_edit->category_id = $request->category_id;
        $section_banner_edit->link = $request->link;
        $section_banner_edit->type = 'header';

        if ($request->hasFile('image')) {
            $section_banner_edit->image = fileUpload($request->image, 'promotions/header_categories');
        } else {
            $section_banner_edit->image = $request->oldImage;
        }

        if ($request->is_published == 'on') {
            $section_banner_edit->is_published = true;
        } else {
            $section_banner_edit->is_published = false;
        }

        $section_banner_edit->save();

        Alert::success(translate('Done'), translate('Updated Successfully'));
        return back();
    }


    /**POP UP */

    // header_banner
    public function popup()
    {
        $categories = Category::Published()->where('parent_category_id', 0)->get();
        return view('backend.promotions.popup.index', compact('categories'));
    }


    // header_banner_store
    public function popup_store(Request $request)
    {
        $popup_banner = new Promotion();
        $popup_banner->category_id = $request->category_id;
        $popup_banner->link = $request->link;
        $popup_banner->type = 'popup';

        if ($request->hasFile('image')) {
            $popup_banner->image = fileUpload($request->image, 'promotions/popups');
        }

        if ($request->is_published == 'on') {
            $popup_banner->is_published = true;
        } else {
            $popup_banner->is_published = false;
        }

        $popup_banner->save();

        Alert::success(translate('Done'), translate('Added Successfully'));
        return back();
    }

    // header_banner_edit
    public function popup_edit($id)
    {
        $categories = Category::Published()->where('parent_category_id', 0)->get();
        $popup_edit = Promotion::findOrFail($id);
        return view('backend.promotions.popup.edit', compact('categories', 'popup_edit'));
    }

    // popup_update
    public function popup_update(Request $request, $id)
    {
        $popup_update = Promotion::findOrFail($id);
        $popup_update->category_id = $request->category_id;
        $popup_update->link = $request->link;
        $popup_update->type = 'popup';

        if ($request->hasFile('image')) {
            $popup_update->image = fileUpload($request->image, 'promotions/popups');
        } else {
            $popup_update->image = $request->oldImage;
        }

        if ($request->is_published == 'on') {
            $popup_update->is_published = true;
        } else {
            $popup_update->is_published = false;
        }

        $popup_update->save();

        Alert::success(translate('Done'), translate('Updated Successfully'));
        return back();
    }



    // promotion_activation
    public function promotion_activation(Request $request)
    {
        // Promotion
        $promotion_activation = Promotion::where('id', $request->id)->first();

        if ($promotion_activation->is_published == 0) {
            $promotion_activation->is_published = 1;
            $promotion_activation->save();
        } else {
            $promotion_activation->is_published = 0;
            $promotion_activation->save();
        }

        return response(['message' => 'Status changed'], 200);
    }

    // PromotionDelete
    public function PromotionDelete($id)
    {
        // Promotion
        Promotion::where('id', $id)->delete();

        Alert::success(translate('Done'), translate('Deleted Successfully'));
        return back();
    }

// END
}


