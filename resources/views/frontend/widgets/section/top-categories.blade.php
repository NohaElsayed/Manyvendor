<div class="ps-top-categories">
    <div class="container">
        <div class="ps-section__header">
            <h3>@translate(TOP CATEGORIES OF THE MONTH)</h3>
        </div>
        <div class="ps-section__content"></div>
        <div class="row align-content-lg-stretch">
            @forelse (categories(10, null) as $home_category)
            @if ($home_category->top == 1)
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                  <div class="ps-block--category-2 br-10" data-mh="categories">
                      <div class="ps-block__thumbnail ml-4"><img src="{{ filePath($home_category->image) }}" alt="" class="rounded-left"></div>
                      <div class="ps-block__content">
                          <h4>{{ $home_category->name }}</h4>
                          <ul>
                            @php
                                $category_limit = 0;
                            @endphp
                            @foreach($home_category->childrenCategories as $parent_Cat)
                              @foreach($parent_Cat->childrenCategories as $sub_cat)

                                <input type="hidden" value="{{ $category_limit++ }}">
                                <li><a href="{{ route('category.shop',$sub_cat->slug) }}">{{ $sub_cat->name }}</a></li>
                               
                                @if ($category_limit == 13)
                                    @break
                                @endif
                               
                              @endforeach

                              @if ($category_limit == 13)
                                    @break
                                @endif
                                
                            @endforeach
                          </ul>
                      </div>
                  </div>
              </div>
            @endif
            
            @empty
            <img src="{{ asset('no-category-found.jpg') }}" class="img-fluid" alt="#no-category-found">
           @endforelse
        </div>
    </div>
</div>
