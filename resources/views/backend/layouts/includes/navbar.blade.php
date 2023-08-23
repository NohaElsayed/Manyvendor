<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav float-left">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-align-right fs-18"></i></a>
        </li>
        <li class="nav-item d-sm-inline-block">
            <a href="{{route('homepage')}}" target="_blank" class="nav-link" title="Browse frontend">
                <i class="fas fa-globe fs-18"></i>
            </a>
        </li>
    </ul>


    <ul class="navbar-nav ml-auto">

        {{--currency--}}
        <li class="dropdown mx-2">
            <div class="m-2">
                <a class="dropdown-toggle text-dark" href="#" role="button" id="languagelink"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false"><span class="live-icon">
                                        {{Str::ucfirst(defaultCurrency())}}
                                    </span><span class="feather icon-chevron-down live-icon"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="languagelink">
                    @foreach(\App\Models\Currency::where('is_published',true)->get() as $item)
                        <a class="dropdown-item" href="{{route('currencies.change')}}" onclick="event.preventDefault();
                            document.getElementById('{{$item->name}}').submit()">
                            <img width="25" height="auto" src="{{ asset("images/lang/". $item->image) }}" alt=""/>
                            {{$item->name}}</a>
                        <form id="{{$item->name}}" class="d-none" action="{{ route('currencies.change') }}"
                              method="POST">
                            @csrf
                            <input type="hidden" name="code" value="{{$item->id}}">
                        </form>
                    @endforeach
                </div>
            </div>

        </li>

        {{--languages--}}
        <li class="dropdown mx-2">
            <div class="m-2">
                <a class="dropdown-toggle text-dark" href="#" role="button" id="languagelink"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false"><span class="live-icon">
                                        {{Str::ucfirst(\Illuminate\Support\Facades\Session::get('locale') ?? env('DEFAULT_LANGUAGE'))}}
                                    </span><span class="feather icon-chevron-down live-icon"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="languagelink">
                    @foreach(\App\Models\Language::all() as $language)
                        <a class="dropdown-item" href="{{route('language.change')}}" onclick="event.preventDefault();
                            document.getElementById('{{$language->name}}').submit()">
                            <img width="25" height="auto" src="{{ asset("images/lang/". $language->image) }}" alt=""/>
                            {{$language->name}}</a>
                        <form id="{{$language->name}}" class="d-none" action="{{ route('language.change') }}"
                              method="POST">
                            @csrf
                            <input type="hidden" name="code" value="{{$language->code}}">
                        </form>
                    @endforeach
                </div>
            </div>

        </li>


        <!-- Notofications Dropdown Menu -->
        @if(\Illuminate\Support\Facades\Auth::user()->user_type != "Deliver")
            <li class="dropdown mx-2">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-danger navbar-badge">{{ orderCount('pending') }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="{{ route('orders.index') }}" class="dropdown-item">
                        <!-- Notofications Start -->
                        <div class="media">
                            <img src="{{asset('shopping_success.png')}}"
                                 alt="{{\Illuminate\Support\Facades\Auth::user()->name}}"
                                 class="img-size-50 mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    {{ orderCount('pending') }} new order placed
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                            </div>
                        </div>
                        <!-- Notofications End -->
                    </a>
                </div>
            </li>
        @endif


        <li class="dropdown user user-menu  mx-2">
            <a class="dropdown-toggle" href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                <img src="{{filePath(\Illuminate\Support\Facades\Auth::user()->avatar)}}"
                     class="img-circle m-b-1" width="40px" height="40px"
                     alt="{{filePath(\Illuminate\Support\Facades\Auth::user()->name)}}">
            </a>
            <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton">

                @canany('seller')
                    <a class="dropdown-item" href="{{route('vendor.profile',\Illuminate\Support\Facades\Auth::id())}}">@translate(Profile)</a>
                @endcanany

                @if(\Illuminate\Support\Facades\Auth::user()->user_type == "Admin")
                    <a class="dropdown-item" href="{{route('users.edit',\Illuminate\Support\Facades\Auth::id())}}">@translate(Profile)</a>
                @endif

                @if(\Illuminate\Support\Facades\Auth::user()->user_type == "Deliver")
                    <a class="dropdown-item" href="{{route('deliver.profile')}}">@translate(Profile)</a>
                @endif

                <a class="dropdown-divider"></a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    @translate(Logout)
                </a>

                <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>

            </div>

        </li>

        <!--Setting-->
        <li class="nav-item d-none">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>

    </ul>
</nav>
