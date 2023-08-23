<div class="ps-section__left">
    <ul class="menu--dropdown category-scroll hide-scrollbar">

      @foreach(categories(100,null) as $gCat)
            @if($gCat->childrenCategories->count() > 0)
        <li class="current-menu-item menu-item-has-children has-mega-menu">
          <a href="{{ route('category.shop',$gCat->slug) }}"><i class="{{ $gCat->icon }}"></i> {{ $gCat->name }}</a>
            <div class="mega-menu">
                <div class="mega-menu__column">
                    <div class="row">
                        @foreach($gCat->childrenCategories as $pCat)
                            @if($pCat->childrenCategories->count() > 0)
                                <div class="col-4 mb-5">
                                    <h4>{{$pCat->name}}</h4>
                                    <hr>

                                    <ul class="mega-menu__list">
                                        @foreach($pCat->childrenCategories as $sCat)
                                            <li class="current-menu-item "><a
                                                    href="{{ route('category.shop',$sCat->slug) }}">{{$sCat->name}}</a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>

                            @endif
                        @endforeach

                    </div>

                </div>

                <div class="card w-30 brand-overflow">
                    @foreach (brandsShuffle(4) as $brandShuffle)
                        <img class="card-img-top mb-2" src="{{ filePath($brandShuffle->logo) }}" alt="#{{ $brandShuffle->name }}">
                    @endforeach
                </div>

            </div>

        </li>

            @endif
      @endforeach

    </ul>
</div>
