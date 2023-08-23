<header class="header header--mobile" data-sticky="true">
    <div class="header__top">
        <div class="header__left">
           
        </div>
        <div class="header__right">
            <ul class="navigation__extra">
                @if(vendorActive())
                    <li><a href="{{ route('vendor.signup') }}">@translate(Apply Seller)</a></li>
                @endif
               
                <li>
                    <div class="ps-dropdown"><a href="#">{{Str::ucfirst(defaultCurrency())}}</a>
                        <ul class="ps-dropdown-menu  dropdown-menu-right">
                            @foreach(\App\Models\Currency::where('is_published',true)->get() as $item)
                                <li><a class="dropdown-item" href="{{route('frontend.currencies.change')}}"
                                       onclick="event.preventDefault();
                                           document.getElementById('{{$item->name}}').submit()">
                                        <img width="25" height="auto" src="{{ asset("images/lang/". $item->image) }}"
                                             alt=""/>
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
    <div class="navigation--mobile">
        <div class="navigation__left"><a class="ps-logo" href="{{ route('homepage') }}"><img
                    src="{{ filePath(getSystemSetting('type_logo'))}}" class="" alt=""></a></div>
        <div class="navigation__right">
            <div class="header__actions">
                {{-- Add Mobile header menu here --}}
                @auth
                    <div class="ps-cart--mini">
                        <a class="header__extra" href="{{ route('customer.track.order') }}">
                            <i class="icon-truck"></i>
                        </a>
                    </div>
                @endauth
                {{-- Add Mobile header menu here:END --}}
                <div class="ps-block--user-header">
                        @auth
                            <div class="ps-block__left">
                                @if (Auth::user()->user_type == 'Customer')
                                    <a href="{{ route('customer.index') }}">
                                        <i class="icon-user"></i>
                                    </a>
                                @else
                                    <i class="icon-user"></i>
                                @endif
                            </div>
                        @endauth

                        @guest
                            <div class="ps-block__left">
                                <a href="{{ route('login') }}">
                                    <i class="icon-user"></i>
                                </a>
                            </div>
                            @endguest
                </div>
            </div>
        </div>
    </div>
   
</header>
