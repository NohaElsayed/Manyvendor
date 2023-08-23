<header class="header header--market-place-3" data-sticky="true">
    <div class="nav-top">
        <div class="container">
            <div class="row">
                <div class="col-12 text-right">
                    <ul class="navigation__extra">

                        @if(deliverActive())
                            <li><a href="{{ route('deliver.signup') }}">@translate(Be a Delivery Man)</a></li>
                        @endif


                        @if(affiliateRoute() && affiliateActive())
                            @auth
                                @if(Auth::user()->user_type != "Admin" && Auth::user()->user_type != "Vendor")
                                    <li><a href="{{ route('customers.affiliate.registration') }}">@translate(Affiliate
                                            Marketing)</a></li>
                                @endif
                            @endauth
                            @guest
                                <li><a href="{{ route('customers.affiliate.registration') }}">@translate(Affiliate
                                        Marketing)</a></li>
                            @endguest
                        @endif

                        @if(vendorActive())
                            <li><a href="{{ route('vendor.signup') }}">@translate(Be a seller)</a></li>

                        @endif
                        <li>
                            <div class="ps-dropdown"><a href="#">{{Str::ucfirst(defaultCurrency())}}</a>
                                <ul class="ps-dropdown-menu  dropdown-menu-right">
                                    @foreach(\App\Models\Currency::where('is_published',true)->get() as $item)
                                        <li><a class="dropdown-item" href="{{route('frontend.currencies.change')}}"
                                               onclick="event.preventDefault();
                                                       document.getElementById('{{$item->name}}').submit()">
                                                <img width="25" height="auto"
                                                     src="{{ asset("images/lang/". $item->image) }}" alt=""/>
                                                {{$item->name}}</a>
                                            <form id="{{$item->name}}" class="d-none"
                                                  action="{{ route('frontend.currencies.change') }}"
                                                  method="POST">
                                                @csrf
                                                <input type="hidden" name="code" value="{{$item->id}}">
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="ps-dropdown language"><a
                                        href="#">{{Str::ucfirst(\Illuminate\Support\Facades\Session::get('locale') ?? env('DEFAULT_LANGUAGE'))}}</a>
                                <ul class="ps-dropdown-menu  dropdown-menu-right">
                                    @foreach(\App\Models\Language::all() as $language)
                                        <li><a class="dropdown-item" href="{{route('frontend.language.change')}}"
                                               onclick="event.preventDefault();
                                                       document.getElementById('{{$language->name}}').submit()">
                                                <img width="25" height="auto"
                                                     src="{{ asset("images/lang/". $language->image) }}" alt=""/>
                                                {{$language->name}}</a>
                                            <form id="{{$language->name}}" class="d-none"
                                                  action="{{ route('frontend.language.change') }}"
                                                  method="POST">
                                                @csrf
                                                <input type="hidden" name="code" value="{{$language->code}}">
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header__top">
        <div class="container">
            <div class="header__left">
                <div class="menu--product-categories">
                    <div class="menu__toggle"><i class="icon-menu text-white"></i><span class="text-white"> @translate(Categories)</span>
                    </div>
                    <div class="menu__content">
                        <ul class="menu--dropdown category-scroll hide-scrollbar">

                            @foreach(categories(100,null) as $gCat)
                                @if($gCat->childrenCategories->count() > 0)
                                    <li class="current-menu-item menu-item-has-children has-mega-menu ">
                                        <a href="{{ route('category.shop',$gCat->slug) }}"><i
                                                    class="{{ $gCat->icon }}"></i> {{ $gCat->name }}</a>
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

                                            <div class="card w-30 h-500">
                                                @foreach (brandsShuffle(4) as $brandShuffle)
                                                    @if($brandShuffle != null)
                                                        <img class="card-img-top mb-2"
                                                             src="{{ filePath($brandShuffle->logo) }}"
                                                             alt="#{{ $brandShuffle->name }}">
                                                    @endif
                                                @endforeach
                                            </div>

                                        </div>

                                    </li>

                                @endif
                            @endforeach

                        </ul>
                    </div>
                </div>
                <a class="ps-logo" href="{{ route('homepage') }}">
                    <img src="{{ filePath(getSystemSetting('type_logo'))}}" class="" alt="">
                </a>
            </div>
            <div class="header__center position-relative">
                <form class="ps-form--quick-search" id="search-form" action="{{route('product.search')}}" method="get">

                    <input class="form-control" name="key" id="filter_input" type="text"  value="{{Request::get('key')}}" placeholder="I'm shopping for...">
                    <div class="form-group--icon w-40"><i class="icon-chevron-down"></i>
                        <input type="hidden" id="filter_url" value="{{ route('header.search') }}">

                        <select class="form-control" name="filter_type" id="filter_type">
                            <option value="product" selected>@translate(Product)</option>
                            @if(vendorActive())
                                <option value="shop">@translate(Shop)</option>
                            @endif
                        </select>
                    </div>
                    <button type="submit">Search</button>
                </form>

                {{-- Search result --}}
                <div class="search-table d-none">
                    <div class="row m-auto p-3" id="show_data">
                        {{-- Data goes here --}}
                    </div>
                </div>
                {{-- Search result:END --}}


            </div>
            <div class="header__right">
                <div class="header__actions">

                    <div class="ps-cart--mini"><a class="header__extra" href="#"><i
                                    class="las la-exchange-alt"></i><span><i
                                        class="navbar-comparison">@translate(0)</i></span></a>
                        <div class="ps-cart__content">
                            <div class="ps-cart__items">
                                <div class="mb-3">@translate(Comparison Items)</div>
                                <span class=" show-comparison-items">
                                {{-- data coming from ajax --}}
                                </span>
                            </div>
                            <div class="ps-cart__footer comparison-items-footer">
                                {{-- data coming from ajax --}}
                            </div>
                        </div>
                    </div>

                    <div class="ps-cart--mini">
                        <a class="header__extra" href="#"><i class="icon-heart"></i>
                            <span>
                                <i class="navbar-wishlist" id="listitem">@translate(0)</i>
                            </span>
                        </a>
                        <div class="ps-cart__content">
                            <div class="ps-cart__items {{  authWishlist() > 0 ? 'h-600' : 'h-400' }}">
                                <div class="mb-3">
                                    @translate(Wishlist Items)
                                    <span id="testCount">

                                    </span>
                                </div>

                                <input type="hidden" value="{{filePath('wishlist.png')}}" class="empty_wishlist_img">
                                <span class="show-wishlist-items" id="show-wishlist-items">
                                                            {{-- data coming from ajax --}}
                                    {{-- data coming from LocalStorage --}}
                                                        </span>


                            </div>

                            <div class="text-center bg-white p-3 wishlist-items-footer" id="show-all-wishlist">
                                {{-- show-all-wishlist --}}
                                {{-- Show All Wishlist --}}
                            </div>
                        </div>
                    </div>

                    <div class="ps-cart--mini"><a class="header__extra" href="#"><i
                                    class="las la-shopping-bag"></i><span><i
                                        class="navbar-cart">@translate(0)</i></span></a>
                        <div class="ps-cart__content">
                            <div class="ps-cart__items h-600">
                                <div class="mb-2">@translate(Cart Items)</div>
                                <span class="show-cart-items">
                                {{-- data coming from ajax --}}
                                </span>
                            </div>
                            @auth
                                <div class="ps-cart__footer cart-items-footer">
                                    {{-- data coming from ajax --}}
                                </div>
                            @endauth
                            @guest
                                <div class="ps-cart__footer cart-items-footer">

                                </div>
                            @endguest
                        </div>
                    </div>

                    @auth
                        <div class="ps-cart--mini">
                            <a class="header__extra" href="{{ route('customer.track.order') }}">
                                <i class="las la-truck-moving"></i>
                            </a>
                        </div>
                    @endauth

                    <div class="ps-block--user-header">
                        @if (Route::has('login'))
                            @auth
                                @if (Auth::user()->user_type == 'Customer')
                                    <a href="{{ route('customer.index') }}">

                                        @if (Str::substr(Auth::user()->avatar, 0, 7) == 'uploads')

                                            <img src="{{ filePath(Auth::user()->avatar) }}"
                                                 class="ps-block--user-header-img w-100 img-fluid"
                                                 alt="{{ Auth::user()->name }}">
                                        @else
                                            <img src="{{ asset(Auth::user()->avatar) }}"
                                                 class="ps-block--user-header-img w-100 img-fluid"
                                                 alt="{{ Auth::user()->name }}">
                                        @endif


                                    </a>
                                @else
                                    <a href="{{ route('home') }}">
                                        <img src="{{ filePath(Auth::user()->avatar) }}"
                                             class="ps-block--user-header-img w-100 img-fluid"
                                             alt="{{ Auth::user()->name }}">
                                    </a>
                                @endif

                            @else
                                <div class=" ps-block__left">
                                    <i class="las la-user"></i></div>

                                <div class="ps-block__right">
                                    <a href="{{ route('login') }}">@translate(Login)</a></div>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navigation">
        <div class="container">
            <div class="navigation__left">
                <div class="menu--product-categories">
                    <div class="menu__toggle active"><i
                                class="icon-menu"></i><span> @translate(Categories)</span></div>
                    <div class="menu__content">
                        <ul class="menu--dropdown category-scroll hide-scrollbar">

                            @foreach(categories(10,null) as $gCat)
                                @if($gCat->childrenCategories->count() > 0)
                                    <li class="current-menu-item menu-item-has-children has-mega-menu">
                                        <a href="{{ route('category.shop',$gCat->slug) }}"><i
                                                    class="{{ $gCat->icon }}"></i> {{ $gCat->name }}</a>
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

                                            <div class="card w-30">
                                                @foreach (brandsShuffle(4) as $brandShuffle)
                                                    <img class="card-img-top mb-2"
                                                         src="{{ filePath($brandShuffle->logo) }}"
                                                         alt="#{{ $brandShuffle->name }}">
                                                @endforeach
                                            </div>

                                        </div>

                                    </li>

                                @endif
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
            <div class="navigation__right">
                <ul class="menu menu--recent-view">
                    <li><a href="{{ route('all.product') }}">@translate(All Products)</a></li>
                    @if(vendorActive())
                        <li><a href="{{ route('vendor.shops') ?? '' }}">@translate(All Shops)</a></li>
                        <li><a href="{{ route('brands') ?? '' }}">@translate(All Brands)</a></li>
                    @endif

                    <li><a href="{{ route('customer.campaigns.index') }}">@translate(Campaigns)</a></li>
                </ul>

            </div>
        </div>
    </nav>
</header>

<script>
    $(document).ready(function () {

        $('#filter_input').on('keyup', function () {

            var url = $('#filter_url').val();
            var type = $('#filter_type').val();
            var input = $('#filter_input').val();

            /*ajax get value*/
            if (url === null) {
                location.reload()
            } else {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        type: type,
                        input: input
                    },
                    success: function (result) {
                        if (input === null || input === '') {
                            $('#show_data').addClass('d-none');
                            $('.search-table').addClass('d-none');
                        } else {
                            $('#show_data').html(result);
                            $('#show_data').removeClass('d-none');
                            $('.search-table').removeClass('d-none');
                        }
                    }
                });


            }
        })
    });

</script>
