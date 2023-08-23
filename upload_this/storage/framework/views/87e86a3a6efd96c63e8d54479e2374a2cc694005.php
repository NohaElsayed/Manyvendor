<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="<?php echo e(route('home')); ?>" class="d-flex justify-content-center m-2">
        <img src="<?php echo e(filePath(getSystemSetting('type_logo'))); ?>" alt="<?php echo e(getSystemSetting('type_name')); ?>"
             class="img-fluid aside-logo">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3  d-none">
            <?php if(session('status')): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>
            <div class="image">
                <img src="<?php echo e(filePath(Auth::user()->avatar)); ?>" class="img-circle elevation-2"
                     alt="<?php echo e(Auth::user()->name); ?>">
            </div>
            <div class="info">
                <a href="<?php echo e(route('users.show',Auth::id())); ?>" class="d-block"> <?php echo e(Auth::user()->name); ?></a>
                <strong class="text-white"><?php echo e(Auth::user()->email); ?></strong>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('dashboard')): ?>
                    <li class="nav-item <?php echo e(request()->is('dashboard/home*') ||request()->is('/') ? 'active':null); ?>">
                        <a href="<?php echo e(route('home')); ?>"
                           class="nav-link <?php echo e(request()->is('dashboard/home*') ||request()->is('/') ? 'active':null); ?>">
                            <i class="fa fa-dashboard nav-icon"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(vendorActive()): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('seller')): ?>
                        <li class="nav-item <?php echo e(request()->is('dashboard/seller') ? 'active':null); ?>">
                            <a href="<?php echo e(route('seller.dashboard')); ?>"
                               class="nav-link <?php echo e(request()->is('dashboard/seller')  ? 'active':null); ?>">
                                <i class="fa fa-dashboard nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>


                <?php if(auth()->check() && auth()->user()->hasAnyPermission('user-management','user-setup','group-setup','permissions-manage')){?>
                <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/user*') || request()->is('dashboard/module*') || request()->is('dashboard/permission*') || request()->is('dashboard/group*') ? 'menu-open' : null); ?>">
                    <a href="#"
                       class="nav-link <?php echo e(request()->is('dashboard/user*') || request()->is('dashboard/module*') || request()->is('dashboard/permission*') || request()->is('dashboard/group*') ? 'active' : null); ?>">
                        <i class="fa fa-users nav-icon"></i>
                        <p>
                            User Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('user-setup')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('users.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/user*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('group-setup')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('groups.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/group*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Groups</p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('permissions-manage-none')): ?>
                            <li class="nav-item ">
                                <a href="<?php echo e(route('modules.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/module*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Permissions</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('permissions.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/permission*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Permission</p>
                                    <strong>remove bro</strong>
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </li>
                <?php } ?>


                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('deliver-management')): ?>
                    <?php if(deliverActive()): ?>
                        <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/deliver*')  ? 'menu-open' : null); ?>">
                            <a href="#"
                               class="nav-link <?php echo e(request()->is('dashboard/deliver*')   ? 'active' : null); ?>">
                                <i class="fa fa-book nav-icon"></i>
                                <p>
                                    Delivery Users
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item <?php echo e(request()->is('dashboard/deliver/request*')  ?'active':null); ?>">
                                    <a href="<?php echo e(route('deliver.request')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/deliver/request*')  ?'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Request List
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->is('dashboard/deliver/index*')  ?'active':null); ?>">
                                    <a href="<?php echo e(route('deliver.index')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/deliver/index*')  ?'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Delivery User List
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>


                <?php if(auth()->check() && auth()->user()->hasAnyPermission('brand-manage','product-manage','product-variant-manage','category-management')){?>
                <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/products/brands*') ||
                              request()->is('dashboard/category*') ||
                              request()->is('dashboard/product*') ||
                              request()->is('dashboard/request/product/index') ||
                              request()->is('dashboard/variant*') ? 'menu-open' : null); ?>">
                    <a href="#"
                       class="nav-link <?php echo e(request()->is('dashboard/products/brands*') ||
                              request()->is('dashboard/category*') ||
                              request()->is('dashboard/product*') ||
                              request()->is('dashboard/request/product/index') ||
                              request()->is('dashboard/variant*') ? 'active' : null); ?>">
                        <i class="fa fa-product-hunt nav-icon"></i>
                        <p>
                            Manage Product
                            <i class="right fas fa-angle-left"></i>
                            <?php if(\App\Models\Product::where('is_request',1)->count()>0 || \App\Models\Brand::where('is_requested',1)->count()>0  || \App\Models\Category::where('is_requested',1)->count()>0 && vendorActive()): ?>
                                <img src="<?php echo e(asset('new.gif')); ?>" class="w-13" alt="">
                            <?php endif; ?>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand-manage')): ?>
                            <li class="nav-item <?php echo e(request()->is('dashboard/products/brands*') ? 'active':null); ?>">
                                <a href="<?php echo e(route('brands.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/products/brands*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Brands
                                        <?php if(\App\Models\Brand::where('is_requested',1)->count()>0 && vendorActive()): ?>
                                            <span class="badge badge-success">
                                       <?php echo e(\App\Models\Brand::where('is_requested',1)->count()); ?>

                                        </span>
                                        <?php endif; ?>
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-management')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('categories.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/category*')  ?'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Categories
                                        <?php if(\App\Models\Category::where('is_requested',1)->count()>0 && vendorActive()): ?>
                                            <span class="badge badge-success">
                                       <?php echo e(\App\Models\Category::where('is_requested',1)->count()); ?>

                                        </span>
                                        <?php endif; ?>
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-variant-manage')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('variants.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/variant*') ? 'active' : null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Variants

                                    <?php if(newVariationRequest() > 0 ): ?>
                                        <img src="<?php echo e(asset('new.gif')); ?>" class="w-13" alt=""/>
                                    <?php endif; ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product-manage')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.products.create')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/product/create') ? 'active' : null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Add New Product
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.products.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/product/index*')  || request()->is('dashboard/product/edit*') || request()->is('dashboard/product/step/tow/edit/*') ? 'active' : null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Products

                                </a>
                            </li>
                                <?php if(vendorActive()): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('admin.request.products.index')); ?>"
                                           class="nav-link <?php echo e(request()->is('dashboard/request/product/index')   ? 'active' : null); ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            Product Request
                                            <?php if(\App\Models\Product::where('is_request',1)->count()>0 && vendorActive()): ?>
                                                <span class="badge badge-success">
                                       <?php echo e(\App\Models\Product::where('is_request',1)->count()); ?>

                                        </span>
                                            <?php endif; ?>

                                        </a>
                                    </li>
                                <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php } ?>

                <?php if(vendorActive()): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('commission-management')): ?>
                        <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/commission*') ? 'menu-open' : null); ?>">
                            <a href="#"
                               class="nav-link <?php echo e(request()->is('dashboard/commission*') ? 'active' : null); ?>">
                                <i class="fa fa-percent nav-icon"></i>
                                <p>
                                    Manage Commission
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview <?php echo e(request()->is('dashboard/commission*') ? 'active':null); ?>">
                                <li class="nav-item <?php echo e(request()->is('dashboard/commission*') ? 'active':null); ?>">
                                    <a href="<?php echo e(route('commissions.index')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/commission*') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Commissions</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('campaign-manage')): ?>
                    <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/campaign*') ? 'menu-open' : null); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->is('dashboard/campaign*') ? 'active' : null); ?>">
                            <i class="fa fa-cubes nav-icon"></i>
                            <p>
                                Campaigns
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview <?php echo e(request()->is('dashboard/campaign*') ? 'active':null); ?>">
                            <li class="nav-item <?php echo e(request()->is('dashboard/campaign*') ? 'active':null); ?>">
                                <a href="<?php echo e(route('admin.campaign.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/campaign*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Campaign</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('coupon-setup')): ?>
                    <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/seller/coupon*') ? 'menu-open' : null); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->is('dashboard/coupon*') ? 'active' : null); ?>">
                            <i class="fa fa-ticket nav-icon"></i>
                            <p>
                                Coupons
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview <?php echo e(request()->is('dashboard/coupon*') ? 'active':null); ?>">
                            <li class="nav-item">
                                <a href="<?php echo e(route('coupon')); ?>"
                                   class="nav-link  <?php echo e(request()->is('dashboard/coupon*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Create Coupon
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('order-manage')): ?>
                    <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/orders*') ||
                       request()->is('dashboard/find/order*') ||
                       request()->is('dashboard/order/deliver*') ||
                       request()->is('dashboard/filter/*') ? 'menu-open' : null); ?>">
                        <a href="<?php echo e(route('orders.index')); ?>"
                           class="nav-link <?php echo e(request()->is('dashboard/orders*') || request()->is('dashboard/order/deliver*') || request()->is('dashboard/filter/*') || request()->is('dashboard/find/order*') ? 'active' : null); ?>">
                            <i class="fa fa-first-order nav-icon"></i>
                            <p>
                                Manage Order
                                <i class="right fas fa-angle-left"></i>
                                <?php if(orderCount('pending') > 0 ): ?>
                                    <img src="<?php echo e(asset('new.gif')); ?>" class="w-13" alt=""/>
                                <?php endif; ?>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('orders.index')); ?>"
                                   class="nav-link  <?php echo e(request()->is('dashboard/orders*') || request()->is('dashboard/find/order*')  ? 'active' : null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    All Orders
                                    <?php if(orderCount('pending') > 0 ): ?>
                                        <span class="badge badge-success">
                                       <?php echo e(orderCount('pending')); ?>

                                    </span>
                                    <?php endif; ?>

                                </a>

                                <a href="<?php echo e(route("find.filter", 'canceled')); ?>"
                                   class="nav-link  <?php echo e(request()->is('dashboard/filter/canceled') ? 'active' : null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Orders Canceled
                                    <?php if(orderCount('canceled') > 0 ): ?>
                                        <span class="badge badge-success">
                                       <?php echo e(orderCount('canceled')); ?>

                                    </span>
                                    <?php endif; ?>
                                </a>


                                <a href="<?php echo e(route("find.filter", 'processing')); ?>"
                                   class="nav-link  <?php echo e(request()->is('dashboard/filter/processing')  ? 'active' : null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Orders Processing
                                    <?php if(orderCount('processing') > 0 ): ?>
                                        <span class="badge badge-success">
                                       <?php echo e(orderCount('processing')); ?>

                                    </span>
                                    <?php endif; ?>
                                </a>


                                <a href="<?php echo e(route("find.filter", 'quality_check')); ?>"
                                   class="nav-link  <?php echo e(request()->is('dashboard/filter/quality_check')  ? 'active' : null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Orders Quality Check
                                    <?php if(orderCount('quality_check') > 0 ): ?>
                                        <span class="badge badge-success">
                                       <?php echo e(orderCount('quality_check')); ?>

                                    </span>
                                    <?php endif; ?>
                                </a>

                                <a href="<?php echo e(route("find.filter", 'product_dispatched')); ?>"
                                   class="nav-link  <?php echo e(request()->is('dashboard/filter/product_dispatched')  ? 'active' : null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Orders Dispatched
                                    <?php if(orderCount('product_dispatched') > 0 ): ?>
                                        <span class="badge badge-success">
                                       <?php echo e(orderCount('quality_check')); ?>

                                    </span>
                                    <?php endif; ?>
                                </a>

                                <a href="<?php echo e(route("find.filter", 'follow_up')); ?>"
                                   class="nav-link  <?php echo e(request()->is('dashboard/filter/follow_up')  ? 'active' : null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Orders Follow Up
                                    <?php if(orderCount('follow_up') > 0 ): ?>
                                        <span class="badge badge-success">
                                       <?php echo e(orderCount('follow_up')); ?>

                                    </span>
                                    <?php endif; ?>
                                </a>

                                <a href="<?php echo e(route("find.filter", 'delivered')); ?>"
                                   class="nav-link  <?php echo e(request()->is('dashboard/filter/delivered')  ? 'active' : null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Orders Delivered





                                </a>

                                <?php if(\Illuminate\Support\Facades\Auth::user()->user_type == 'Admin' && deliverActive() ): ?>
                                    <a href="<?php echo e(route('deliver.order.list')); ?>"
                                       class="nav-link  <?php echo e(request()->is('dashboard/order/deliver/list')  ? 'active' : null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        Delivery Man Status
                                        <?php if(orderCount('confirmed') > 0 ): ?>
                                            <span class="badge badge-success">
                                       <?php echo e(orderCount('confirmed')); ?>

                                                <?php endif; ?>
                                    </span>
                                    </a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('fullfill-manage')): ?>
                    <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/fullfillment/orders*') || request()->is('dashboard/fullfillment/logistic/*') ? 'menu-open' : null); ?>">
                        <a href="<?php echo e(route('fullfillment.index')); ?>"
                           class="nav-link <?php echo e(request()->is('dashboard/fullfillment/orders*') ? 'active' : null); ?>">
                            <i class="fa fa-truck nav-icon"></i>
                            <p>
                                Fulfillment
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">

                                <a href="<?php echo e(route('fullfillment.index')); ?>"
                                   class="nav-link  <?php echo e(request()->is('dashboard/fullfillment/orders*') || request()->is('dashboard/fullfillment/logistic/*') ? 'active' : null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Find In Logistics
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                
                <?php if(vendorActive()): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('seller-management')): ?>
                        <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/create*')
                            || request()->is('dashboard/requests*')
                            || request()->is('dashboard/seller/view*')
                            || request()->is('dashboard/all*') ? 'menu-open' : null); ?>">
                            <a href="#"
                               class="nav-link <?php echo e(request()->is('dashboard/create*')
                                || request()->is('dashboard/all*')
                                || request()->is('dashboard/seller/view*')
                                || request()->is('dashboard/requests*') ? 'active' : null); ?>">
                                <i class="fa fa-user nav-icon"></i>
                                <p>
                                    Manage Seller
                                    <?php if(App\Vendor::where('approve_status',0)->count() > 0 ): ?>
                                        <img src="<?php echo e(asset('new.gif')); ?>" class="w-13" alt="">
                                    <?php endif; ?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item <?php echo e(request()->is('dashboard/create*') ? 'active':null); ?>">
                                    <a href="<?php echo e(route('vendor.create')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/create*') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add New Seller</p>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->is('dashboard/requests*') ? 'active':null); ?>">
                                    <a href="<?php echo e(route('vendor.requests')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/requests*') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Seller Request
                                            <?php if(App\Vendor::where('approve_status',0)->count() > 0 ): ?>
                                                <span class="badge badge-success ml-2">
                                                    <?php echo e(App\Vendor::where('approve_status',0)->count()); ?>

                                                </span>
                                            <?php endif; ?>
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->is('dashboard/all*') || request()->is('dashboard/seller/view*')? 'active':null); ?>">
                                    <a href="<?php echo e(route('vendor.all')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/all*') || request()->is('dashboard/seller/view*') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Seller</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('seller')): ?>
                        <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/seller/campaign*') ? 'menu-open' : null); ?>">
                            <a href="#"
                               class="nav-link <?php echo e(request()->is('dashboard/seller/campaign*') ? 'active' : null); ?>">
                                <i class="fa fa-cube nav-icon"></i>
                                <p>
                                    
                                    Campaigns
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item <?php echo e(request()->is('dashboard/seller/campaign*') ? 'active':null); ?>">
                                    <a href="<?php echo e(route('seller.campaign.index')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/seller/campaign*') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Campaign</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#!"
                                       onclick="forModal('<?php echo e(route('seller.campaign.create')); ?>', 'Request for campaign')"
                                       class="nav-link">
                                        <i class="fa fa-recycle nav-icon"></i>
                                        <?php if(sellerMode()): ?>
                                            Request Campaign
                                            <?php else: ?>
                                            Add New Campaign
                                            <?php endif; ?>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/seller/product*') || request()->is('dashboard/seller/product/request') || request()->is('dashboard/seller/product/edit*') ? 'menu-open' : null); ?>">
                            <a href="#"
                               class="nav-link <?php echo e(request()->is('dashboard/seller/product/upload*') || request()->is('dashboard/seller/product/request') || request()->is('dashboard/seller/product/edit*')? 'active' : null); ?>">
                                <i class="fa fa-puzzle-piece nav-icon"></i>
                                <p>
                                    Manage Product
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item <?php echo e(request()->is('dashboard/seller/product/upload*') ? 'active' : null); ?>">
                                    <a href="<?php echo e(route('seller.product.upload')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/seller/product/upload*') ? 'active' : null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        Add Product
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->is('dashboard/seller/products*') || request()->is('dashboard/seller/product/edit*') ? 'active' : null); ?>">
                                    <a href="<?php echo e(route('seller.products')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/seller/products*') || request()->is('dashboard/seller/product/edit*') ? 'active' : null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        Products
                                    </a>
                                </li>

                                <li class="nav-item <?php echo e(request()->is('dashboard/seller/product/request') ? 'active' : null); ?>">
                                    <a href="<?php echo e(route("seller.product.request")); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/seller/product/request') ? 'active' : null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <?php if(sellerMode()): ?>
                                            Request New Product
                                        <?php else: ?>
                                            Add New Product
                                        <?php endif; ?>
                                    </a>
                                </li>
                            </ul>
                        </li>




                        <li class="nav-item">
                            <a href="#!"
                               onclick="forModal('<?php echo e(route('seller.brands.create')); ?>', 'Request a Brand')"
                               class="nav-link">
                                <i class="fa fa-certificate nav-icon"></i>
                                <?php if(sellerMode()): ?>
                                    Request New Brand
                                <?php else: ?>
                                    Add New Brand
                                <?php endif; ?>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#!"
                               onclick="forModal('<?php echo e(route('seller.categories.create')); ?>', 'Request a Category')"
                               class="nav-link">
                                <i class="fa fa-gamepad nav-icon"></i>
                                <?php if(sellerMode()): ?>
                                    Request New Category
                                <?php else: ?>
                                    Add New Category
                                <?php endif; ?>
                            </a>
                        </li>

                        <li class="nav-item <?php echo e(request()->is('dashboard/seller/variation/request*') ? 'menu-open' : null); ?>">
                            <a href="<?php echo e(route('seller.variation.request.create')); ?>"
                               class="nav-link">
                                <i class="fa fa-gamepad nav-icon"></i>
                                <?php if(sellerMode()): ?>
                                    Request New Variation
                                <?php else: ?>
                                    Add New Variation
                                <?php endif; ?>
                            </a>
                        </li>

                        <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/seller/payment*') ||request()->is('dashboard/seller/account*') ? 'menu-open' : null); ?>">
                            <a href="#"
                               class="nav-link <?php echo e(request()->is('dashboard/seller/payment*') || request()->is('dashboard/seller/account*') ? 'active' : null); ?>">
                                <i class="fa fa-money nav-icon"></i>
                                <p>
                                    Withdraw Method
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item <?php echo e(request()->is('dashboard/seller/payment*') ? 'active':null); ?>">
                                    <a href="<?php echo e(route('payments.index')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/seller/payment*') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Withdraw</p>
                                    </a>
                                </li>

                                <li class="nav-item <?php echo e(request()->is('dashboard/seller/account*') ? 'active':null); ?>">
                                    <a href="<?php echo e(route('account.create')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/seller/account*') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Setup Account</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/seller/earning*') ? 'menu-open' : null); ?>">
                            <a href="#"
                               class="nav-link <?php echo e(request()->is('dashboard/seller/earning*') ? 'active' : null); ?>">
                                <i class="fa fa-dollar nav-icon"></i>
                                <p>
                                    Earnings
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item <?php echo e(request()->is('dashboard/seller/earning*') ? 'active':null); ?>">
                                    <a href="<?php echo e(route('seller.earning.index')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/seller/earning*') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Overview</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php endif; ?>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('complain-manage')): ?>
                    <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/complains*')  || request()->is('dashboard/find/complain*') || request()->is('dashboard/complain/solved/*') || request()->is('dashboard/complain/notsolved/*') || request()->is('dashboard/complain/filter/*') ? 'menu-open' : null); ?>">
                        <a href="<?php echo e(route('fullfillment.index')); ?>"
                           class="nav-link <?php echo e(request()->is('dashboard/complains*') || request()->is('dashboard/find/complain*')|| request()->is('dashboard/complain/filter*') ? 'active' : null); ?>">
                            <i class="fa fa-thumbs-o-down nav-icon"></i>
                            <p>
                                Manage Complain

                                <i class="right fas fa-angle-left"></i>
                                <?php if(complainCount('Untouched') > 0 ): ?>
                                    <img src="<?php echo e(asset('new.gif')); ?>" class="w-13" alt="">
                                <?php endif; ?>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">

                                <a href="<?php echo e(route('complains.index')); ?>"
                                   class="nav-link  <?php echo e(request()->is('dashboard/complains*')
                                    || request()->is('dashboard/complain/solved/*')
                                    || request()->is('dashboard/complain/notsolved/*')
                                    || request()->is('dashboard/complain/filter/*')
                                      || request()->is('dashboard/find/complain*')? 'active' : null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Complains
                                    <?php if(complainCount('Untouched') > 0 ): ?>
                                        <span class="badge badge-success"><?php echo e(complainCount('Untouched')); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php endif; ?>


            <!-- Promotions START -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('promotions-banner-setup')): ?>
                    <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/promotions/*') ? 'menu-open' : null); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->is('dashboard/promotions/*') ? 'active' : null); ?>">
                            <i class="fa fa-bullhorn nav-icon"></i>
                            <p>
                                Promotions
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item <?php echo e(request()->is('dashboard/promotions/category*') ? 'active':null); ?>">
                                <a href="<?php echo e(route('category.promotion')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/promotions/category*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Category Promotions</p>
                                </a>
                            </li>

                            <li class="nav-item <?php echo e(request()->is('dashboard/promotions/header*') ? 'active':null); ?>">
                                <a href="<?php echo e(route('header.promotion')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/promotions/header*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Slider Widgets</p>
                                </a>
                            </li>

                            <li class="nav-item <?php echo e(request()->is('dashboard/promotions/main/slider*') ? 'active':null); ?>">
                                <a href="<?php echo e(route('main.slider.promotion')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/promotions/main/slider*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Main Slider</p>
                                </a>
                            </li>

                            <li class="nav-item <?php echo e(request()->is('dashboard/promotions/popup') ? 'active':null); ?>">
                                <a href="<?php echo e(route('popup.promotion')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/promotions/popup') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pop Up</p>
                                </a>
                            </li>

                            <li class="nav-item <?php echo e(request()->is('dashboard/promotions/section/banner*') ? 'active':null); ?>">
                                <a href="<?php echo e(route('section.promotion')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/promotions/section/banner*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Section</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Promotions END -->
                <?php endif; ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('pages-manage')): ?>
                    <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/page/group*') ||
                 request()->is('dashboard/pages*') ||
                 request()->is('dashboard/info*') ||
                  request()->is('dashboard/content*') ? 'menu-open' : null); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->is('dashboard/page/group*') ||
                         request()->is('dashboard/pages*') ||
                         request()->is('dashboard/content*')  ? 'active' : null); ?>">
                            <i class="fa fa-book nav-icon"></i>
                            <p>
                                Pages
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item <?php echo e(request()->is('dashboard/page/group*')  ?'active':null); ?>">
                                <a href="<?php echo e(route('pages.group.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/page/group*')  ?'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Page group
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(request()->is('dashboard/pages*') || request()->is('dashboard/content*') ?'active':null); ?>">
                                <a href="<?php echo e(route('pages.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/pages*') || request()->is('dashboard/content*') ?'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Pages
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(request()->is('dashboard/info*') ?'active':null); ?>">
                                <a href="<?php echo e(route('info.page.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/info*') ?'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Info Page
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('shipping-setup')): ?>
                    <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/shipping/zone*') ||
                             request()->is('dashboard/shipping/logistics*') || request()->is('dashboard/shipping/logistic/*') ? 'menu-open' : null); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->is('dashboard/shipping/zone*') ||
                           request()->is('dashboard/shipping/logistics*') || request()->is('dashboard/shipping/logistic/*') ? 'active' : null); ?>">
                            <i class="fa fa-ship nav-icon"></i>
                            <p>
                                Shipping
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('shipping.zone')); ?>"
                                   class="nav-link  <?php echo e(request()->is('dashboard/shipping/zone*') || request()->is('dashboard/shipping/logistic/*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Shipping Zone
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?php echo e(route('logistics')); ?>"
                                   class="nav-link  <?php echo e(request()->is('dashboard/shipping/logistics*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    Logistics
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php endif; ?>



                <?php if(vendorActive()): ?>
                    
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('seller-payment')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.payments.index')); ?>"
                               class="nav-link <?php echo e(request()->is('dashboard/seller-payment*') ? 'active' : null); ?>">
                                <i class="fa fa-money nav-icon"></i>
                                <p>
                                    Seller Payment
                                    <?php if(\App\Models\Payment::where('status','!=','Confirm')->count() >0): ?>
                                        <span
                                                class="badge badge-warning"><?php echo e(\App\Models\Payment::where('status','!=','Confirm')->count()); ?></span>
                                    <?php endif; ?>
                                </p>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>


                
                <?php if(vendorActive()): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('admin-earning')): ?>
                        <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/earning*') ? 'menu-open' : null); ?>">
                            <a href="#"
                               class="nav-link <?php echo e(request()->is('dashboard/earning*')  ? 'active' : null); ?>">
                                <i class="fa fa-dollar nav-icon"></i>
                                <p>
                                    Admin Earning
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('earning.index')); ?>"
                                       class="nav-link  <?php echo e(request()->is('dashboard/earning*') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        Earnings
                                    </a>
                                </li>

                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>


                <?php if(affiliateActive() && affiliateRoute()): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('affiliate-management')): ?>
                        <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/affiliate*') ? 'menu-open' : null); ?>">
                            <a href="#"
                               class="nav-link <?php echo e(request()->is('dashboard/affiliate*')  ? 'active' : null); ?>">
                                <i class="fa fa-adn nav-icon"></i>
                                <p>
                                    Affiliate Area
                                    <i class="right fas fa-angle-left"></i>
                                    <?php if(\App\Models\AffiliateAccount::where('is_approved',0)->where('is_blocked',0)->get()->count()>0 || \App\Models\AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled',0)->get()->count()>0): ?>
                                        <img src="<?php echo e(asset('new.gif')); ?>" class="w-13" alt="">
                                    <?php endif; ?>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('admins.affiliate.index')); ?>"
                                       class="nav-link  <?php echo e(request()->is('dashboard/affiliate-accounts') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        Affiliate Accounts
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?php echo e(route('admins.affiliate.requestedUsers')); ?>"
                                       class="nav-link  <?php echo e(request()->is('dashboard/affiliate-requested-users') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        New Requests
                                        <?php if(\App\Models\AffiliateAccount::where('is_approved',0)->where('is_blocked',0)->get()->count()>0): ?>
                                            <span class="badge badge-success">
                                                <?php echo e(\App\Models\AffiliateAccount::where('is_approved',0)->where('is_blocked',0)->get()->count()); ?>

                                            </span>
                                        <?php endif; ?>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?php echo e(route('admins.affiliate.affiliatePayments')); ?>"
                                       class="nav-link  <?php echo e(request()->is('dashboard/affiliate-payments') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        Payments
                                        <?php if(\App\Models\AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled',0)->get()->count()>0): ?>
                                            <span class="badge badge-success">
                                                <?php echo e(\App\Models\AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled',0)->get()->count()); ?>

                                            </span>
                                        <?php endif; ?>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?php echo e(route('admins.affiliate.settings')); ?>"
                                       class="nav-link  <?php echo e(request()->is('dashboard/affiliate-settings') ? 'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        Settings
                                    </a>
                                </li>

                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if(auth()->check() && auth()->user()->hasAnyPermission('section-setting','site-setting')){?>
                    <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/business/setting*')
                 || request()->is('dashboard/section/setting*')
                 || request()->is('dashboard/org-setting*')
                 ? 'menu-open' : null); ?>">
                        <a href="#"
                           class="nav-link
                       <?php echo e(request()->is('dashboard/business/setting*')
                       || request()->is('dashboard/section/setting*')
                       || request()->is('dashboard/org-setting*')? 'active' : null); ?>">
                            <i class="fa fa-shopping-cart nav-icon"></i>
                            <p>
                                Frontend Settings
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('section-setting')): ?>
                            <li class="nav-item <?php echo e(request()->is('dashboard/section/setting*') ? 'active':null); ?>">
                                <a href="<?php echo e(route('section.setting.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/section/setting*') ? 'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sections</p>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('site-setting')): ?>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('site.setting')); ?>"
                                       class="nav-link <?php echo e(request()->is('dashboard/org-setting*') ?'active':null); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>General Settings</p>
                                    </a>
                                </li>
                            <?php endif; ?>


                        </ul>
                    </li>
                <?php } ?>


                <?php if(auth()->check() && auth()->user()->hasAnyPermission('payment-method-setup',
                'currency-setup',
                'language-setup',
                'app-active',
                'mail-setup',
                'additional-setting',
                'site-setting')){?>
                <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/smtp*')
                                   || request()->is('dashboard/language*')
                                   || request()->is('dashboard/slider*')
                                   || request()->is('dashboard/setting*')
                                   || request()->is('dashboard/currency*')
                                   || request()->is('dashboard/socialite*')
                                   ||request()->is('dashboard/business/system-settings*')
                                   || request()->is('dashboard/payment/method*')
                                   || request()->is('dashboard/app/active*')
                                    ? 'menu-open' : null); ?>">
                    <a href="#" class="nav-link <?php echo e(request()->is('dashboard/smtp*')
                                   || request()->is('dashboard/language*')
                                   || request()->is('dashboard/slider*')
                                   || request()->is('dashboard/setting*')
                                   || request()->is('dashboard/currency*')
                                   || request()->is('dashboard/socialite*')
                                   || request()->is('dashboard/payment/method*')
                                   || request()->is('dashboard/app/active*')
                                   ||request()->is('dashboard/business/system-settings*')? 'active' : null); ?>">
                        <i class="fa fa-cogs nav-icon"></i>
                        <p>
                            Site Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('language-setup')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('language.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/language*') ?'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Languages Settings</p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('currency-setup')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('currencies.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/currency*') ?'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Currency Settings</p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('mail-setup')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('smtp.create')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/smtp*') ?'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>SMTP Settings</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('additional-setting')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('socialite.env.setting')); ?>"
                               class="nav-link <?php echo e(request()->is('dashboard/socialite*') ?'active':null); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Social Login</p>
                            </a>
                        </li>
                            <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payment-method-setup')): ?>
                            <li class="nav-item <?php echo e(request()->is('dashboard/payment/method*') ?'active':null); ?>">
                                <a href="<?php echo e(route('payment.method.index')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/payment/method*') ?'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Payment Methods</p>
                                </a>
                            </li>
                        <?php endif; ?>


                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('app-active')): ?>
                            <li class="nav-item <?php echo e(request()->is('dashboard/app/active*') ?'active':null); ?>">
                                <a href="<?php echo e(route('app.active')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/app/active*') ?'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Switch Mode</p>
                                </a>
                            </li>
                        <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('site-setting')): ?>
                        <li class="nav-item <?php echo e(request()->is('dashboard/business/system-settings*') ? 'active':null); ?>">
                            <a href="<?php echo e(route('business.setting.index')); ?>"
                               class="nav-link <?php echo e(request()->is('dashboard/business/system-settings*') ? 'active':null); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>System Settings</p>
                            </a>
                        </li>
                            <?php endif; ?>
                    </ul>
                </li>
                <?php } ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('addons-manager')): ?>
                    <?php if(env('ADDONS_MANAGER') == 'YES'): ?>
                        <li class="nav-item <?php echo e(request()->is('dashboard/addons-manager*') || request()->is('dashboard/paytm*') || request()->is('dashboard/paytm*') ? 'active':null); ?>">
                            <a href="<?php echo e(route('addons.manager.index')); ?>"
                               class="nav-link <?php echo e(request()->is('dashboard/addons-manager*') || request()->is('dashboard/paytm*')  || request()->is('dashboard/paytm*') ? 'active':null); ?>">
                                <i class="fa fa-gift nav-icon"></i>
                                <p>Addons Manager</p>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>


                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('deliver')): ?>
                    <li class="nav-item has-treeview <?php echo e(request()->is('dashboard/deliver*')  ? 'menu-open' : null); ?>">
                        <a href="#"
                           class="nav-link <?php echo e(request()->is('dashboard/deliver*')   ? 'active' : null); ?>">
                            <i class="fa fa-book nav-icon"></i>
                            <p>
                                Dashboard
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item <?php echo e(request()->is('dashboard/deliver/pending')  ?'active':null); ?>">
                                <a href="<?php echo e(route('deliver.dashboard')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/deliver/pending')  ?'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Pending Orders
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(request()->is('dashboard/deliver/orderDelivered')  ?'active':null); ?>">
                                <a href="<?php echo e(route('deliver.allDeliver')); ?>"
                                   class="nav-link <?php echo e(request()->is('dashboard/deliver/orderDelivered')  ?'active':null); ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Delivered Orders
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/layouts/includes/aside.blade.php ENDPATH**/ ?>