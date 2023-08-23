<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{route('home')}}" class="d-flex justify-content-center m-2">
        <img src="{{filePath(getSystemSetting('type_logo'))}}" alt="{{getSystemSetting('type_name')}}"
             class="img-fluid aside-logo">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 {{-- d-flex --}} d-none">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="image">
                <img src="{{filePath(Auth::user()->avatar)}}" class="img-circle elevation-2"
                     alt="{{ Auth::user()->name }}">
            </div>
            <div class="info">
                <a href="{{route('users.show',Auth::id())}}" class="d-block"> {{ Auth::user()->name }}</a>
                <strong class="text-white">{{Auth::user()->email}}</strong>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                @canany('dashboard')
                    <li class="nav-item {{request()->is('dashboard/home*') ||request()->is('/') ? 'active':null}}">
                        <a href="{{route('home')}}"
                           class="nav-link {{request()->is('dashboard/home*') ||request()->is('/') ? 'active':null}}">
                            <i class="fa fa-dashboard nav-icon"></i>
                            <p>@translate(Dashboard)</p>
                        </a>
                    </li>
                @endcanany


                @if(vendorActive())
                    @canany('seller')
                        <li class="nav-item {{request()->is('dashboard/seller') ? 'active':null}}">
                            <a href="{{route('seller.dashboard')}}"
                               class="nav-link {{request()->is('dashboard/seller')  ? 'active':null}}">
                                <i class="fa fa-dashboard nav-icon"></i>
                                <p>@translate(Dashboard)</p>
                            </a>
                        </li>
                    @endcanany
                @endif


                @anypermission('user-management','user-setup','group-setup','permissions-manage')
                <li class="nav-item has-treeview {{request()->is('dashboard/user*') || request()->is('dashboard/module*') || request()->is('dashboard/permission*') || request()->is('dashboard/group*') ? 'menu-open' : null}}">
                    <a href="#"
                       class="nav-link {{request()->is('dashboard/user*') || request()->is('dashboard/module*') || request()->is('dashboard/permission*') || request()->is('dashboard/group*') ? 'active' : null}}">
                        <i class="fa fa-users nav-icon"></i>
                        <p>
                            @translate(User Management)
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @canany('user-setup')
                            <li class="nav-item">
                                <a href="{{route('users.index')}}"
                                   class="nav-link {{request()->is('dashboard/user*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Users)</p>
                                </a>
                            </li>
                        @endcanany
                        @canany('group-setup')
                            <li class="nav-item">
                                <a href="{{route('groups.index')}}"
                                   class="nav-link {{request()->is('dashboard/group*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Groups)</p>
                                </a>
                            </li>
                        @endcanany
                        @canany('permissions-manage-none')
                            <li class="nav-item ">
                                <a href="{{route('modules.index')}}"
                                   class="nav-link {{request()->is('dashboard/module*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Permissions)</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('permissions.index')}}"
                                   class="nav-link {{request()->is('dashboard/permission*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Permission)</p>
                                    <strong>remove bro</strong>
                                </a>
                            </li>
                        @endcanany

                    </ul>
                </li>
                @endanypermission


                {{--todo::here asid menu for deliver--}}
                @canany('deliver-management')
                    @if(deliverActive())
                        <li class="nav-item has-treeview {{request()->is('dashboard/deliver*')  ? 'menu-open' : null}}">
                            <a href="#"
                               class="nav-link {{request()->is('dashboard/deliver*')   ? 'active' : null}}">
                                <i class="fa fa-book nav-icon"></i>
                                <p>
                                    @translate(Delivery Users)
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item {{request()->is('dashboard/deliver/request*')  ?'active':null}}">
                                    <a href="{{route('deliver.request')}}"
                                       class="nav-link {{request()->is('dashboard/deliver/request*')  ?'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @translate(Request List)
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item {{request()->is('dashboard/deliver/index*')  ?'active':null}}">
                                    <a href="{{route('deliver.index')}}"
                                       class="nav-link {{request()->is('dashboard/deliver/index*')  ?'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @translate(Delivery User List)
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endcan


                @anypermission('brand-manage','product-manage','product-variant-manage','category-management')
                <li class="nav-item has-treeview {{request()->is('dashboard/products/brands*') ||
                              request()->is('dashboard/category*') ||
                              request()->is('dashboard/product*') ||
                              request()->is('dashboard/request/product/index') ||
                              request()->is('dashboard/variant*') ? 'menu-open' : null}}">
                    <a href="#"
                       class="nav-link {{request()->is('dashboard/products/brands*') ||
                              request()->is('dashboard/category*') ||
                              request()->is('dashboard/product*') ||
                              request()->is('dashboard/request/product/index') ||
                              request()->is('dashboard/variant*') ? 'active' : null}}">
                        <i class="fa fa-product-hunt nav-icon"></i>
                        <p>
                            @translate(Manage Product)
                            <i class="right fas fa-angle-left"></i>
                            @if(\App\Models\Product::where('is_request',1)->count()>0 || \App\Models\Brand::where('is_requested',1)->count()>0  || \App\Models\Category::where('is_requested',1)->count()>0 && vendorActive())
                                <img src="{{ asset('new.gif') }}" class="w-13" alt="">
                            @endif
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('brand-manage')
                            <li class="nav-item {{request()->is('dashboard/products/brands*') ? 'active':null}}">
                                <a href="{{route('brands.index')}}"
                                   class="nav-link {{request()->is('dashboard/products/brands*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Brands)
                                        @if(\App\Models\Brand::where('is_requested',1)->count()>0 && vendorActive())
                                            <span class="badge badge-success">
                                       {{ \App\Models\Brand::where('is_requested',1)->count() }}
                                        </span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('category-management')
                            <li class="nav-item">
                                <a href="{{route('categories.index')}}"
                                   class="nav-link {{request()->is('dashboard/category*')  ?'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @translate(Categories)
                                        @if(\App\Models\Category::where('is_requested',1)->count()>0 && vendorActive())
                                            <span class="badge badge-success">
                                       {{ \App\Models\Category::where('is_requested',1)->count() }}
                                        </span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('product-variant-manage')
                            <li class="nav-item">
                                <a href="{{route('variants.index')}}"
                                   class="nav-link {{request()->is('dashboard/variant*') ? 'active' : null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Variants)

                                    @if (newVariationRequest() > 0 )
                                        <img src="{{ asset('new.gif') }}" class="w-13" alt=""/>
                                    @endif

                                </a>
                            </li>
                        @endcan
                        @can('product-manage')
                            <li class="nav-item">
                                <a href="{{route('admin.products.create')}}"
                                   class="nav-link {{request()->is('dashboard/product/create') ? 'active' : null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Add New Product)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.products.index')}}"
                                   class="nav-link {{request()->is('dashboard/product/index*')  || request()->is('dashboard/product/edit*') || request()->is('dashboard/product/step/tow/edit/*') ? 'active' : null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Products)

                                </a>
                            </li>
                                @if(vendorActive())
                                    <li class="nav-item">
                                        <a href="{{route('admin.request.products.index')}}"
                                           class="nav-link {{request()->is('dashboard/request/product/index')   ? 'active' : null}}">
                                            <i class="far fa-circle nav-icon"></i>
                                            @translate(Product Request)
                                            @if(\App\Models\Product::where('is_request',1)->count()>0 && vendorActive())
                                                <span class="badge badge-success">
                                       {{ \App\Models\Product::where('is_request',1)->count() }}
                                        </span>
                                            @endif

                                        </a>
                                    </li>
                                @endif
                        @endcan
                    </ul>
                </li>
                @endanypermission

                @if(vendorActive())
                    @canany('commission-management')
                        <li class="nav-item has-treeview {{request()->is('dashboard/commission*') ? 'menu-open' : null}}">
                            <a href="#"
                               class="nav-link {{request()->is('dashboard/commission*') ? 'active' : null}}">
                                <i class="fa fa-percent nav-icon"></i>
                                <p>
                                    @translate(Manage Commission)
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview {{request()->is('dashboard/commission*') ? 'active':null}}">
                                <li class="nav-item {{request()->is('dashboard/commission*') ? 'active':null}}">
                                    <a href="{{route('commissions.index')}}"
                                       class="nav-link {{request()->is('dashboard/commission*') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>@translate(Commissions)</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                @endif

                @canany('campaign-manage')
                    <li class="nav-item has-treeview {{request()->is('dashboard/campaign*') ? 'menu-open' : null}}">
                        <a href="#"
                           class="nav-link {{request()->is('dashboard/campaign*') ? 'active' : null}}">
                            <i class="fa fa-cubes nav-icon"></i>
                            <p>
                                @translate(Campaigns)
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview {{request()->is('dashboard/campaign*') ? 'active':null}}">
                            <li class="nav-item {{request()->is('dashboard/campaign*') ? 'active':null}}">
                                <a href="{{route('admin.campaign.index')}}"
                                   class="nav-link {{request()->is('dashboard/campaign*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(All Campaign)</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcanany

                @canany('coupon-setup')
                    <li class="nav-item has-treeview {{request()->is('dashboard/seller/coupon*') ? 'menu-open' : null}}">
                        <a href="#"
                           class="nav-link {{request()->is('dashboard/coupon*') ? 'active' : null}}">
                            <i class="fa fa-ticket nav-icon"></i>
                            <p>
                                @translate(Coupons)
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview {{request()->is('dashboard/coupon*') ? 'active':null}}">
                            <li class="nav-item">
                                <a href="{{route('coupon')}}"
                                   class="nav-link  {{request()->is('dashboard/coupon*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Create Coupon)
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcanany


                @canany('order-manage')
                    <li class="nav-item has-treeview {{request()->is('dashboard/orders*') ||
                       request()->is('dashboard/find/order*') ||
                       request()->is('dashboard/order/deliver*') ||
                       request()->is('dashboard/filter/*') ? 'menu-open' : null}}">
                        <a href="{{ route('orders.index') }}"
                           class="nav-link {{request()->is('dashboard/orders*') || request()->is('dashboard/order/deliver*') || request()->is('dashboard/filter/*') || request()->is('dashboard/find/order*') ? 'active' : null}}">
                            <i class="fa fa-first-order nav-icon"></i>
                            <p>
                                @translate(Manage Order)
                                <i class="right fas fa-angle-left"></i>
                                @if (orderCount('pending') > 0 )
                                    <img src="{{ asset('new.gif') }}" class="w-13" alt=""/>
                                @endif
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('orders.index')}}"
                                   class="nav-link  {{request()->is('dashboard/orders*') || request()->is('dashboard/find/order*')  ? 'active' : null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(All Orders)
                                    @if (orderCount('pending') > 0 )
                                        <span class="badge badge-success">
                                       {{ orderCount('pending') }}
                                    </span>
                                    @endif

                                </a>

                                <a href="{{ route("find.filter", 'canceled') }}"
                                   class="nav-link  {{request()->is('dashboard/filter/canceled') ? 'active' : null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Orders Canceled)
                                    @if (orderCount('canceled') > 0 )
                                        <span class="badge badge-success">
                                       {{ orderCount('canceled') }}
                                    </span>
                                    @endif
                                </a>


                                <a href="{{route("find.filter", 'processing')}}"
                                   class="nav-link  {{request()->is('dashboard/filter/processing')  ? 'active' : null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Orders Processing)
                                    @if (orderCount('processing') > 0 )
                                        <span class="badge badge-success">
                                       {{ orderCount('processing') }}
                                    </span>
                                    @endif
                                </a>


                                <a href="{{route("find.filter", 'quality_check')}}"
                                   class="nav-link  {{request()->is('dashboard/filter/quality_check')  ? 'active' : null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Orders Quality Check)
                                    @if (orderCount('quality_check') > 0 )
                                        <span class="badge badge-success">
                                       {{ orderCount('quality_check') }}
                                    </span>
                                    @endif
                                </a>

                                <a href="{{route("find.filter", 'product_dispatched')}}"
                                   class="nav-link  {{request()->is('dashboard/filter/product_dispatched')  ? 'active' : null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Orders Dispatched)
                                    @if (orderCount('product_dispatched') > 0 )
                                        <span class="badge badge-success">
                                       {{ orderCount('quality_check') }}
                                    </span>
                                    @endif
                                </a>

                                <a href="{{route("find.filter", 'follow_up')}}"
                                   class="nav-link  {{request()->is('dashboard/filter/follow_up')  ? 'active' : null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Orders Follow Up)
                                    @if (orderCount('follow_up') > 0 )
                                        <span class="badge badge-success">
                                       {{ orderCount('follow_up') }}
                                    </span>
                                    @endif
                                </a>

                                <a href="{{route("find.filter", 'delivered')}}"
                                   class="nav-link  {{request()->is('dashboard/filter/delivered')  ? 'active' : null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Orders Delivered)
{{--                                    @if (orderCount('delivered') > 0 )--}}
{{--                                        <span class="badge badge-success">--}}
{{--                                       {{ orderCount('delivered') }}--}}
{{--                                    </span>--}}
{{--                                    @endif--}}
                                </a>

                                @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'Admin' && deliverActive() )
                                    <a href="{{route('deliver.order.list')}}"
                                       class="nav-link  {{request()->is('dashboard/order/deliver/list')  ? 'active' : null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        @translate(Delivery Man Status)
                                        @if (orderCount('confirmed') > 0 )
                                            <span class="badge badge-success">
                                       {{ orderCount('confirmed') }}
                                                @endif
                                    </span>
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </li>
                @endcanany

                @canany('fullfill-manage')
                    <li class="nav-item has-treeview {{request()->is('dashboard/fullfillment/orders*') || request()->is('dashboard/fullfillment/logistic/*') ? 'menu-open' : null}}">
                        <a href="{{ route('fullfillment.index') }}"
                           class="nav-link {{request()->is('dashboard/fullfillment/orders*') ? 'active' : null}}">
                            <i class="fa fa-truck nav-icon"></i>
                            <p>
                                @translate(Fulfillment)
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">

                                <a href="{{route('fullfillment.index')}}"
                                   class="nav-link  {{ request()->is('dashboard/fullfillment/orders*') || request()->is('dashboard/fullfillment/logistic/*') ? 'active' : null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Find In Logistics)
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcanany

                {{--ecommerce not need seller/vendor  option--}}
                @if(vendorActive())
                    @canany('seller-management')
                        <li class="nav-item has-treeview {{request()->is('dashboard/create*')
                            || request()->is('dashboard/requests*')
                            || request()->is('dashboard/seller/view*')
                            || request()->is('dashboard/all*') ? 'menu-open' : null}}">
                            <a href="#"
                               class="nav-link {{request()->is('dashboard/create*')
                                || request()->is('dashboard/all*')
                                || request()->is('dashboard/seller/view*')
                                || request()->is('dashboard/requests*') ? 'active' : null}}">
                                <i class="fa fa-user nav-icon"></i>
                                <p>
                                    @translate(Manage Seller)
                                    @if (App\Vendor::where('approve_status',0)->count() > 0 )
                                        <img src="{{ asset('new.gif') }}" class="w-13" alt="">
                                    @endif
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item {{request()->is('dashboard/create*') ? 'active':null}}">
                                    <a href="{{route('vendor.create')}}"
                                       class="nav-link {{request()->is('dashboard/create*') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>@translate(Add New Seller)</p>
                                    </a>
                                </li>
                                <li class="nav-item {{request()->is('dashboard/requests*') ? 'active':null}}">
                                    <a href="{{route('vendor.requests')}}"
                                       class="nav-link {{request()->is('dashboard/requests*') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>@translate(Seller Request)
                                            @if (App\Vendor::where('approve_status',0)->count() > 0 )
                                                <span class="badge badge-success ml-2">
                                                    {{ App\Vendor::where('approve_status',0)->count() }}
                                                </span>
                                            @endif
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item {{request()->is('dashboard/all*') || request()->is('dashboard/seller/view*')? 'active':null}}">
                                    <a href="{{route('vendor.all')}}"
                                       class="nav-link {{request()->is('dashboard/all*') || request()->is('dashboard/seller/view*') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>@translate(All Seller)</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcanany

                    @canany('seller')
                        <li class="nav-item has-treeview {{request()->is('dashboard/seller/campaign*') ? 'menu-open' : null}}">
                            <a href="#"
                               class="nav-link {{request()->is('dashboard/seller/campaign*') ? 'active' : null}}">
                                <i class="fa fa-cube nav-icon"></i>
                                <p>
                                    {{--seller--}}
                                    @translate(Campaigns)
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item {{request()->is('dashboard/seller/campaign*') ? 'active':null}}">
                                    <a href="{{route('seller.campaign.index')}}"
                                       class="nav-link {{request()->is('dashboard/seller/campaign*') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>@translate(All Campaign)</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#!"
                                       onclick="forModal('{{ route('seller.campaign.create') }}', '@translate(Request for campaign)')"
                                       class="nav-link">
                                        <i class="fa fa-recycle nav-icon"></i>
                                        @if(sellerMode())
                                            @translate(Request Campaign)
                                            @else
                                            @translate(Add New Campaign)
                                            @endif
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-item has-treeview {{request()->is('dashboard/seller/product*') || request()->is('dashboard/seller/product/request') || request()->is('dashboard/seller/product/edit*') ? 'menu-open' : null}}">
                            <a href="#"
                               class="nav-link {{request()->is('dashboard/seller/product/upload*') || request()->is('dashboard/seller/product/request') || request()->is('dashboard/seller/product/edit*')? 'active' : null}}">
                                <i class="fa fa-puzzle-piece nav-icon"></i>
                                <p>
                                    @translate(Manage Product)
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item {{request()->is('dashboard/seller/product/upload*') ? 'active' : null}}">
                                    <a href="{{ route('seller.product.upload') }}"
                                       class="nav-link {{request()->is('dashboard/seller/product/upload*') ? 'active' : null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        @translate(Add Product)
                                    </a>
                                </li>
                                <li class="nav-item {{request()->is('dashboard/seller/products*') || request()->is('dashboard/seller/product/edit*') ? 'active' : null}}">
                                    <a href="{{route('seller.products')}}"
                                       class="nav-link {{request()->is('dashboard/seller/products*') || request()->is('dashboard/seller/product/edit*') ? 'active' : null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        @translate(Products)
                                    </a>
                                </li>

                                <li class="nav-item {{request()->is('dashboard/seller/product/request') ? 'active' : null}}">
                                    <a href="{{ route("seller.product.request") }}"
                                       class="nav-link {{request()->is('dashboard/seller/product/request') ? 'active' : null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        @if(sellerMode())
                                            @translate(Request New Product)
                                        @else
                                            @translate(Add New Product)
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </li>




                        <li class="nav-item">
                            <a href="#!"
                               onclick="forModal('{{ route('seller.brands.create') }}', '@translate(Request a Brand)')"
                               class="nav-link">
                                <i class="fa fa-certificate nav-icon"></i>
                                @if(sellerMode())
                                    @translate(Request New Brand)
                                @else
                                    @translate(Add New Brand)
                                @endif
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#!"
                               onclick="forModal('{{ route('seller.categories.create') }}', '@translate(Request a Category)')"
                               class="nav-link">
                                <i class="fa fa-gamepad nav-icon"></i>
                                @if(sellerMode())
                                    @translate(Request New Category)
                                @else
                                    @translate(Add New Category)
                                @endif
                            </a>
                        </li>

                        <li class="nav-item {{request()->is('dashboard/seller/variation/request*') ? 'menu-open' : null}}">
                            <a href="{{ route('seller.variation.request.create') }}"
                               class="nav-link">
                                <i class="fa fa-gamepad nav-icon"></i>
                                @if(sellerMode())
                                    @translate(Request New Variation)
                                @else
                                    @translate(Add New Variation)
                                @endif
                            </a>
                        </li>

                        <li class="nav-item has-treeview {{request()->is('dashboard/seller/payment*') ||request()->is('dashboard/seller/account*') ? 'menu-open' : null}}">
                            <a href="#"
                               class="nav-link {{request()->is('dashboard/seller/payment*') || request()->is('dashboard/seller/account*') ? 'active' : null}}">
                                <i class="fa fa-money nav-icon"></i>
                                <p>
                                    @translate(Withdraw Method)
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item {{request()->is('dashboard/seller/payment*') ? 'active':null}}">
                                    <a href="{{route('payments.index')}}"
                                       class="nav-link {{request()->is('dashboard/seller/payment*') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>@translate(Withdraw)</p>
                                    </a>
                                </li>

                                <li class="nav-item {{request()->is('dashboard/seller/account*') ? 'active':null}}">
                                    <a href="{{route('account.create')}}"
                                       class="nav-link {{request()->is('dashboard/seller/account*') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>@translate(Setup Account)</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item has-treeview {{request()->is('dashboard/seller/earning*') ? 'menu-open' : null}}">
                            <a href="#"
                               class="nav-link {{request()->is('dashboard/seller/earning*') ? 'active' : null}}">
                                <i class="fa fa-dollar nav-icon"></i>
                                <p>
                                    @translate(Earnings)
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item {{request()->is('dashboard/seller/earning*') ? 'active':null}}">
                                    <a href="{{route('seller.earning.index')}}"
                                       class="nav-link {{request()->is('dashboard/seller/earning*') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>@translate(Overview)</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    @endcanany
                @endif

                @canany('complain-manage')
                    <li class="nav-item has-treeview {{request()->is('dashboard/complains*')  || request()->is('dashboard/find/complain*') || request()->is('dashboard/complain/solved/*') || request()->is('dashboard/complain/notsolved/*') || request()->is('dashboard/complain/filter/*') ? 'menu-open' : null}}">
                        <a href="{{ route('fullfillment.index') }}"
                           class="nav-link {{request()->is('dashboard/complains*') || request()->is('dashboard/find/complain*')|| request()->is('dashboard/complain/filter*') ? 'active' : null}}">
                            <i class="fa fa-thumbs-o-down nav-icon"></i>
                            <p>
                                @translate(Manage Complain)

                                <i class="right fas fa-angle-left"></i>
                                @if (complainCount('Untouched') > 0 )
                                    <img src="{{ asset('new.gif') }}" class="w-13" alt="">
                                @endif
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">

                                <a href="{{route('complains.index')}}"
                                   class="nav-link  {{request()->is('dashboard/complains*')
                                    || request()->is('dashboard/complain/solved/*')
                                    || request()->is('dashboard/complain/notsolved/*')
                                    || request()->is('dashboard/complain/filter/*')
                                      || request()->is('dashboard/find/complain*')? 'active' : null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Complains)
                                    @if (complainCount('Untouched') > 0 )
                                        <span class="badge badge-success">{{ complainCount('Untouched') }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </li>

                @endcanany


            <!-- Promotions START -->
                @canany('promotions-banner-setup')
                    <li class="nav-item has-treeview {{request()->is('dashboard/promotions/*') ? 'menu-open' : null}}">
                        <a href="#"
                           class="nav-link {{request()->is('dashboard/promotions/*') ? 'active' : null}}">
                            <i class="fa fa-bullhorn nav-icon"></i>
                            <p>
                                @translate(Promotions)
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item {{request()->is('dashboard/promotions/category*') ? 'active':null}}">
                                <a href="{{route('category.promotion')}}"
                                   class="nav-link {{request()->is('dashboard/promotions/category*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Category Promotions)</p>
                                </a>
                            </li>

                            <li class="nav-item {{request()->is('dashboard/promotions/header*') ? 'active':null}}">
                                <a href="{{route('header.promotion')}}"
                                   class="nav-link {{request()->is('dashboard/promotions/header*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Slider Widgets)</p>
                                </a>
                            </li>

                            <li class="nav-item {{request()->is('dashboard/promotions/main/slider*') ? 'active':null}}">
                                <a href="{{route('main.slider.promotion')}}"
                                   class="nav-link {{request()->is('dashboard/promotions/main/slider*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Main Slider)</p>
                                </a>
                            </li>

                            <li class="nav-item {{request()->is('dashboard/promotions/popup') ? 'active':null}}">
                                <a href="{{route('popup.promotion')}}"
                                   class="nav-link {{request()->is('dashboard/promotions/popup') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Pop Up)</p>
                                </a>
                            </li>

                            <li class="nav-item {{request()->is('dashboard/promotions/section/banner*') ? 'active':null}}">
                                <a href="{{route('section.promotion')}}"
                                   class="nav-link {{request()->is('dashboard/promotions/section/banner*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Section)</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Promotions END -->
                @endcanany


                @canany('pages-manage')
                    <li class="nav-item has-treeview {{request()->is('dashboard/page/group*') ||
                 request()->is('dashboard/pages*') ||
                 request()->is('dashboard/info*') ||
                  request()->is('dashboard/content*') ? 'menu-open' : null}}">
                        <a href="#"
                           class="nav-link {{request()->is('dashboard/page/group*') ||
                         request()->is('dashboard/pages*') ||
                         request()->is('dashboard/content*')  ? 'active' : null}}">
                            <i class="fa fa-book nav-icon"></i>
                            <p>
                                @translate(Pages)
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item {{request()->is('dashboard/page/group*')  ?'active':null}}">
                                <a href="{{route('pages.group.index')}}"
                                   class="nav-link {{request()->is('dashboard/page/group*')  ?'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @translate(Page group)
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item {{request()->is('dashboard/pages*') || request()->is('dashboard/content*') ?'active':null}}">
                                <a href="{{route('pages.index')}}"
                                   class="nav-link {{request()->is('dashboard/pages*') || request()->is('dashboard/content*') ?'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @translate(Pages)
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item {{request()->is('dashboard/info*') ?'active':null}}">
                                <a href="{{route('info.page.index')}}"
                                   class="nav-link {{request()->is('dashboard/info*') ?'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @translate(Info Page)
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan


                @canany('shipping-setup')
                    <li class="nav-item has-treeview {{request()->is('dashboard/shipping/zone*') ||
                             request()->is('dashboard/shipping/logistics*') || request()->is('dashboard/shipping/logistic/*') ? 'menu-open' : null}}">
                        <a href="#"
                           class="nav-link {{request()->is('dashboard/shipping/zone*') ||
                           request()->is('dashboard/shipping/logistics*') || request()->is('dashboard/shipping/logistic/*') ? 'active' : null}}">
                            <i class="fa fa-ship nav-icon"></i>
                            <p>
                                @translate(Shipping)
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('shipping.zone')}}"
                                   class="nav-link  {{request()->is('dashboard/shipping/zone*') || request()->is('dashboard/shipping/logistic/*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Shipping Zone)
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('logistics')}}"
                                   class="nav-link  {{request()->is('dashboard/shipping/logistics*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @translate(Logistics)
                                </a>
                            </li>

                        </ul>
                    </li>
                @endcanany



                @if(vendorActive())
                    {{--here the payment permission--}}
                    @canany('seller-payment')
                        <li class="nav-item">
                            <a href="{{ route('admin.payments.index') }}"
                               class="nav-link {{request()->is('dashboard/seller-payment*') ? 'active' : null}}">
                                <i class="fa fa-money nav-icon"></i>
                                <p>
                                    @translate(Seller Payment)
                                    @if(\App\Models\Payment::where('status','!=','Confirm')->count() >0)
                                        <span
                                                class="badge badge-warning">{{\App\Models\Payment::where('status','!=','Confirm')->count()}}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                    @endcanany
                @endif


                {{--ecommerce not need admin earning--}}
                @if(vendorActive())
                    @canany('admin-earning')
                        <li class="nav-item has-treeview {{request()->is('dashboard/earning*') ? 'menu-open' : null}}">
                            <a href="#"
                               class="nav-link {{request()->is('dashboard/earning*')  ? 'active' : null}}">
                                <i class="fa fa-dollar nav-icon"></i>
                                <p>
                                    @translate(Admin Earning)
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('earning.index')}}"
                                       class="nav-link  {{request()->is('dashboard/earning*') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        @translate(Earnings)
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcanany
                @endif


                @if(affiliateActive() && affiliateRoute())
                    @canany('affiliate-management')
                        <li class="nav-item has-treeview {{request()->is('dashboard/affiliate*') ? 'menu-open' : null}}">
                            <a href="#"
                               class="nav-link {{request()->is('dashboard/affiliate*')  ? 'active' : null}}">
                                <i class="fa fa-adn nav-icon"></i>
                                <p>
                                    @translate(Affiliate Area)
                                    <i class="right fas fa-angle-left"></i>
                                    @if(\App\Models\AffiliateAccount::where('is_approved',0)->where('is_blocked',0)->get()->count()>0 || \App\Models\AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled',0)->get()->count()>0)
                                        <img src="{{ asset('new.gif') }}" class="w-13" alt="">
                                    @endif
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('admins.affiliate.index')}}"
                                       class="nav-link  {{request()->is('dashboard/affiliate-accounts') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        @translate(Affiliate Accounts)
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('admins.affiliate.requestedUsers')}}"
                                       class="nav-link  {{request()->is('dashboard/affiliate-requested-users') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        @translate(New Requests)
                                        @if(\App\Models\AffiliateAccount::where('is_approved',0)->where('is_blocked',0)->get()->count()>0)
                                            <span class="badge badge-success">
                                                {{ \App\Models\AffiliateAccount::where('is_approved',0)->where('is_blocked',0)->get()->count()}}
                                            </span>
                                        @endif
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('admins.affiliate.affiliatePayments')}}"
                                       class="nav-link  {{request()->is('dashboard/affiliate-payments') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        @translate(payments)
                                        @if(\App\Models\AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled',0)->get()->count()>0)
                                            <span class="badge badge-success">
                                                {{ \App\Models\AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled',0)->get()->count()}}
                                            </span>
                                        @endif
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('admins.affiliate.settings')}}"
                                       class="nav-link  {{request()->is('dashboard/affiliate-settings') ? 'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        @translate(Settings)
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcanany
                @endif

                @anypermission('section-setting','site-setting')
                    <li class="nav-item has-treeview {{request()->is('dashboard/business/setting*')
                 || request()->is('dashboard/section/setting*')
                 || request()->is('dashboard/org-setting*')
                 ? 'menu-open' : null}}">
                        <a href="#"
                           class="nav-link
                       {{request()->is('dashboard/business/setting*')
                       || request()->is('dashboard/section/setting*')
                       || request()->is('dashboard/org-setting*')? 'active' : null}}">
                            <i class="fa fa-shopping-cart nav-icon"></i>
                            <p>
                                @translate(Frontend Settings)
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('section-setting')
                            <li class="nav-item {{request()->is('dashboard/section/setting*') ? 'active':null}}">
                                <a href="{{route('section.setting.index')}}"
                                   class="nav-link {{request()->is('dashboard/section/setting*') ? 'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Sections)</p>
                                </a>
                            </li>
                            @endcan
                            @canany('site-setting')
                                <li class="nav-item">
                                    <a href="{{route('site.setting')}}"
                                       class="nav-link {{request()->is('dashboard/org-setting*') ?'active':null}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>@translate(General Settings)</p>
                                    </a>
                                </li>
                            @endcan


                        </ul>
                    </li>
                @endanypermission


                @anypermission('payment-method-setup',
                'currency-setup',
                'language-setup',
                'app-active',
                'mail-setup',
                'additional-setting',
                'site-setting')
                <li class="nav-item has-treeview {{request()->is('dashboard/smtp*')
                                   || request()->is('dashboard/language*')
                                   || request()->is('dashboard/slider*')
                                   || request()->is('dashboard/setting*')
                                   || request()->is('dashboard/currency*')
                                   || request()->is('dashboard/socialite*')
                                   ||request()->is('dashboard/business/system-settings*')
                                   || request()->is('dashboard/payment/method*')
                                   || request()->is('dashboard/app/active*')
                                    ? 'menu-open' : null}}">
                    <a href="#" class="nav-link {{request()->is('dashboard/smtp*')
                                   || request()->is('dashboard/language*')
                                   || request()->is('dashboard/slider*')
                                   || request()->is('dashboard/setting*')
                                   || request()->is('dashboard/currency*')
                                   || request()->is('dashboard/socialite*')
                                   || request()->is('dashboard/payment/method*')
                                   || request()->is('dashboard/app/active*')
                                   ||request()->is('dashboard/business/system-settings*')? 'active' : null}}">
                        <i class="fa fa-cogs nav-icon"></i>
                        <p>
                            @translate(Site Settings)
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @canany('language-setup')
                            <li class="nav-item">
                                <a href="{{route('language.index')}}"
                                   class="nav-link {{request()->is('dashboard/language*') ?'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Languages Settings)</p>
                                </a>
                            </li>
                        @endcanany
                        @canany('currency-setup')
                            <li class="nav-item">
                                <a href="{{route('currencies.index')}}"
                                   class="nav-link {{request()->is('dashboard/currency*') ?'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Currency Settings)</p>
                                </a>
                            </li>
                        @endcanany
                        @canany('mail-setup')
                            <li class="nav-item">
                                <a href="{{route('smtp.create')}}"
                                   class="nav-link {{request()->is('dashboard/smtp*') ?'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(SMTP Settings)</p>
                                </a>
                            </li>
                        @endcanany

                        {{--Todo:: Permission--}}
                            @canany('additional-setting')
                        <li class="nav-item">
                            <a href="{{route('socialite.env.setting')}}"
                               class="nav-link {{request()->is('dashboard/socialite*') ?'active':null}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@translate(Social Login)</p>
                            </a>
                        </li>
                            @endcanany

                        @can('payment-method-setup')
                            <li class="nav-item {{request()->is('dashboard/payment/method*') ?'active':null}}">
                                <a href="{{route('payment.method.index')}}"
                                   class="nav-link {{request()->is('dashboard/payment/method*') ?'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Payment Methods)</p>
                                </a>
                            </li>
                        @endcan


                        @canany('app-active')
                            <li class="nav-item {{request()->is('dashboard/app/active*') ?'active':null}}">
                                <a href="{{route('app.active')}}"
                                   class="nav-link {{request()->is('dashboard/app/active*') ?'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@translate(Switch Mode)</p>
                                </a>
                            </li>
                        @endcanany
                            @canany('site-setting')
                        <li class="nav-item {{request()->is('dashboard/business/system-settings*') ? 'active':null}}">
                            <a href="{{route('business.setting.index')}}"
                               class="nav-link {{request()->is('dashboard/business/system-settings*') ? 'active':null}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@translate(System Settings)</p>
                            </a>
                        </li>
                            @endcan
                    </ul>
                </li>
                @endanypermission


                @canany('addons-manager')
                    @if (env('ADDONS_MANAGER') == 'YES')
                        <li class="nav-item {{ request()->is('dashboard/addons-manager*') || request()->is('dashboard/paytm*') || request()->is('dashboard/paytm*') ? 'active':null}}">
                            <a href="{{route('addons.manager.index')}}"
                               class="nav-link {{ request()->is('dashboard/addons-manager*') || request()->is('dashboard/paytm*')  || request()->is('dashboard/paytm*') ? 'active':null}}">
                                <i class="fa fa-gift nav-icon"></i>
                                <p>@translate(Addons Manager)</p>
                            </a>
                        </li>
                    @endif
                @endcanany


                {{--deliver--}}
                @can('deliver')
                    <li class="nav-item has-treeview {{request()->is('dashboard/deliver*')  ? 'menu-open' : null}}">
                        <a href="#"
                           class="nav-link {{request()->is('dashboard/deliver*')   ? 'active' : null}}">
                            <i class="fa fa-book nav-icon"></i>
                            <p>
                                @translate(Dashboard)
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item {{request()->is('dashboard/deliver/pending')  ?'active':null}}">
                                <a href="{{route('deliver.dashboard')}}"
                                   class="nav-link {{request()->is('dashboard/deliver/pending')  ?'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @translate(Pending Orders)
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item {{request()->is('dashboard/deliver/orderDelivered')  ?'active':null}}">
                                <a href="{{route('deliver.allDeliver')}}"
                                   class="nav-link {{request()->is('dashboard/deliver/orderDelivered')  ?'active':null}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @translate(Delivered Orders)
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
