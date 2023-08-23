<div class="ps-panel--sidebar" id="navigation-mobile">
    <div class="ps-panel__header">
        <h3>@translate(Categories)</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
          @foreach(categories(9,null) as $gCat)
                @if($gCat->childrenCategories->count() > 0)
            <li class="current-menu-item menu-item-has-children has-mega-menu">
              <a href="{{ route('category.shop',$gCat->slug) }}">{{ $gCat->name }}</a>
              <span class="sub-toggle"></span>
                <div class="mega-menu">
                    <div class="mega-menu__column">
                      @foreach($gCat->childrenCategories as $pCat)
                        <h4>{{$pCat->name}}<span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                          @foreach($pCat->childrenCategories as $sCat)
                            <li class="current-menu-item ">
                              <a href="{{ route('category.shop',$sCat->slug) }}">{{$sCat->name}}</a>
                            </li>
                          @endforeach
                        </ul>
                      @endforeach
                    </div>
                </div>
            </li>
                @endif
        @endforeach
        </ul>
    </div>
</div>
