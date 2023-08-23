<header class="header header--market-place-3" data-sticky="true">
    <div class="nav-top">
        <div class="container">
            <div class="row">
                <div class="col-12 text-right">
                    <ul class="navigation__extra">

                        <?php if(deliverActive()): ?>
                            <li><a href="<?php echo e(route('deliver.signup')); ?>">Be a Delivery Man</a></li>
                        <?php endif; ?>


                        <?php if(affiliateRoute() && affiliateActive()): ?>
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(Auth::user()->user_type != "Admin" && Auth::user()->user_type != "Vendor"): ?>
                                    <li><a href="<?php echo e(route('customers.affiliate.registration')); ?>">Affiliate
                                            Marketing</a></li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if(auth()->guard()->guest()): ?>
                                <li><a href="<?php echo e(route('customers.affiliate.registration')); ?>">Affiliate
                                        Marketing</a></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if(vendorActive()): ?>
                            <li><a href="<?php echo e(route('vendor.signup')); ?>">Be a seller</a></li>

                        <?php endif; ?>
                        <li>
                            <div class="ps-dropdown"><a href="#"><?php echo e(Str::ucfirst(defaultCurrency())); ?></a>
                                <ul class="ps-dropdown-menu  dropdown-menu-right">
                                    <?php $__currentLoopData = \App\Models\Currency::where('is_published',true)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a class="dropdown-item" href="<?php echo e(route('frontend.currencies.change')); ?>"
                                               onclick="event.preventDefault();
                                                       document.getElementById('<?php echo e($item->name); ?>').submit()">
                                                <img width="25" height="auto"
                                                     src="<?php echo e(asset("images/lang/". $item->image)); ?>" alt=""/>
                                                <?php echo e($item->name); ?></a>
                                            <form id="<?php echo e($item->name); ?>" class="d-none"
                                                  action="<?php echo e(route('frontend.currencies.change')); ?>"
                                                  method="POST">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="code" value="<?php echo e($item->id); ?>">
                                            </form>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="ps-dropdown language"><a
                                        href="#"><?php echo e(Str::ucfirst(\Illuminate\Support\Facades\Session::get('locale') ?? env('DEFAULT_LANGUAGE'))); ?></a>
                                <ul class="ps-dropdown-menu  dropdown-menu-right">
                                    <?php $__currentLoopData = \App\Models\Language::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a class="dropdown-item" href="<?php echo e(route('frontend.language.change')); ?>"
                                               onclick="event.preventDefault();
                                                       document.getElementById('<?php echo e($language->name); ?>').submit()">
                                                <img width="25" height="auto"
                                                     src="<?php echo e(asset("images/lang/". $language->image)); ?>" alt=""/>
                                                <?php echo e($language->name); ?></a>
                                            <form id="<?php echo e($language->name); ?>" class="d-none"
                                                  action="<?php echo e(route('frontend.language.change')); ?>"
                                                  method="POST">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="code" value="<?php echo e($language->code); ?>">
                                            </form>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <div class="menu__toggle"><i class="icon-menu text-white"></i><span class="text-white"> Categories</span>
                    </div>
                    <div class="menu__content">
                        <ul class="menu--dropdown category-scroll hide-scrollbar">

                            <?php $__currentLoopData = categories(100,null); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($gCat->childrenCategories->count() > 0): ?>
                                    <li class="current-menu-item menu-item-has-children has-mega-menu ">
                                        <a href="<?php echo e(route('category.shop',$gCat->slug)); ?>"><i
                                                    class="<?php echo e($gCat->icon); ?>"></i> <?php echo e($gCat->name); ?></a>
                                        <div class="mega-menu">
                                            <div class="mega-menu__column">
                                                <div class="row">
                                                    <?php $__currentLoopData = $gCat->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($pCat->childrenCategories->count() > 0): ?>
                                                            <div class="col-4 mb-5">
                                                                <h4><?php echo e($pCat->name); ?></h4>
                                                                <hr>

                                                                <ul class="mega-menu__list">
                                                                    <?php $__currentLoopData = $pCat->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <li class="current-menu-item "><a
                                                                                    href="<?php echo e(route('category.shop',$sCat->slug)); ?>"><?php echo e($sCat->name); ?></a>
                                                                        </li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                                </ul>
                                                            </div>

                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </div>

                                            </div>

                                            <div class="card w-30 h-500">
                                                <?php $__currentLoopData = brandsShuffle(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brandShuffle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($brandShuffle != null): ?>
                                                        <img class="card-img-top mb-2"
                                                             src="<?php echo e(filePath($brandShuffle->logo)); ?>"
                                                             alt="#<?php echo e($brandShuffle->name); ?>">
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>

                                        </div>

                                    </li>

                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                    </div>
                </div>
                <a class="ps-logo" href="<?php echo e(route('homepage')); ?>">
                    <img src="<?php echo e(filePath(getSystemSetting('type_logo'))); ?>" class="" alt="">
                </a>
            </div>
            <div class="header__center position-relative">
                <form class="ps-form--quick-search" id="search-form" action="<?php echo e(route('product.search')); ?>" method="get">

                    <input class="form-control" name="key" id="filter_input" type="text"  value="<?php echo e(Request::get('key')); ?>" placeholder="I'm shopping for...">
                    <div class="form-group--icon w-40"><i class="icon-chevron-down"></i>
                        <input type="hidden" id="filter_url" value="<?php echo e(route('header.search')); ?>">

                        <select class="form-control" name="filter_type" id="filter_type">
                            <option value="product" selected>Product</option>
                            <?php if(vendorActive()): ?>
                                <option value="shop">Shop</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <button type="submit">Search</button>
                </form>

                
                <div class="search-table d-none">
                    <div class="row m-auto p-3" id="show_data">
                        
                    </div>
                </div>
                


            </div>
            <div class="header__right">
                <div class="header__actions">

                    <div class="ps-cart--mini"><a class="header__extra" href="#"><i
                                    class="las la-exchange-alt"></i><span><i
                                        class="navbar-comparison">0</i></span></a>
                        <div class="ps-cart__content">
                            <div class="ps-cart__items">
                                <div class="mb-3">Comparison Items</div>
                                <span class=" show-comparison-items">
                                
                                </span>
                            </div>
                            <div class="ps-cart__footer comparison-items-footer">
                                
                            </div>
                        </div>
                    </div>

                    <div class="ps-cart--mini">
                        <a class="header__extra" href="#"><i class="icon-heart"></i>
                            <span>
                                <i class="navbar-wishlist" id="listitem">0</i>
                            </span>
                        </a>
                        <div class="ps-cart__content">
                            <div class="ps-cart__items <?php echo e(authWishlist() > 0 ? 'h-600' : 'h-400'); ?>">
                                <div class="mb-3">
                                    Wishlist Items
                                    <span id="testCount">

                                    </span>
                                </div>

                                <input type="hidden" value="<?php echo e(filePath('wishlist.png')); ?>" class="empty_wishlist_img">
                                <span class="show-wishlist-items" id="show-wishlist-items">
                                                            
                                    
                                                        </span>


                            </div>

                            <div class="text-center bg-white p-3" id="show-all-wishlist">
                                
                                
                            </div>
                        </div>
                    </div>

                    <div class="ps-cart--mini"><a class="header__extra" href="#"><i
                                    class="las la-shopping-bag"></i><span><i
                                        class="navbar-cart">0</i></span></a>
                        <div class="ps-cart__content">
                            <div class="ps-cart__items h-600">
                                <div class="mb-2">Cart Items</div>
                                <span class="show-cart-items">
                                
                                </span>
                            </div>
                            <?php if(auth()->guard()->check()): ?>
                                <div class="ps-cart__footer cart-items-footer">
                                    
                                </div>
                            <?php endif; ?>
                            <?php if(auth()->guard()->guest()): ?>
                                <div class="ps-cart__footer cart-items-footer">

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if(auth()->guard()->check()): ?>
                        <div class="ps-cart--mini">
                            <a class="header__extra" href="<?php echo e(route('customer.track.order')); ?>">
                                <i class="las la-truck-moving"></i>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="ps-block--user-header">
                        <?php if(Route::has('login')): ?>
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(Auth::user()->user_type == 'Customer'): ?>
                                    <a href="<?php echo e(route('customer.index')); ?>">

                                        <?php if(Str::substr(Auth::user()->avatar, 0, 7) == 'uploads'): ?>

                                            <img src="<?php echo e(filePath(Auth::user()->avatar)); ?>"
                                                 class="ps-block--user-header-img w-100 img-fluid"
                                                 alt="<?php echo e(Auth::user()->name); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset(Auth::user()->avatar)); ?>"
                                                 class="ps-block--user-header-img w-100 img-fluid"
                                                 alt="<?php echo e(Auth::user()->name); ?>">
                                        <?php endif; ?>


                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('home')); ?>">
                                        <img src="<?php echo e(filePath(Auth::user()->avatar)); ?>"
                                             class="ps-block--user-header-img w-100 img-fluid"
                                             alt="<?php echo e(Auth::user()->name); ?>">
                                    </a>
                                <?php endif; ?>

                            <?php else: ?>
                                <div class=" ps-block__left">
                                    <i class="las la-user"></i></div>

                                <div class="ps-block__right">
                                    <a href="<?php echo e(route('login')); ?>">Login</a></div>
                            <?php endif; ?>
                        <?php endif; ?>
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
                                class="icon-menu"></i><span> Categories</span></div>
                    <div class="menu__content">
                        <ul class="menu--dropdown category-scroll hide-scrollbar">

                            <?php $__currentLoopData = categories(10,null); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($gCat->childrenCategories->count() > 0): ?>
                                    <li class="current-menu-item menu-item-has-children has-mega-menu">
                                        <a href="<?php echo e(route('category.shop',$gCat->slug)); ?>"><i
                                                    class="<?php echo e($gCat->icon); ?>"></i> <?php echo e($gCat->name); ?></a>
                                        <div class="mega-menu">
                                            <div class="mega-menu__column">
                                                <div class="row">
                                                    <?php $__currentLoopData = $gCat->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($pCat->childrenCategories->count() > 0): ?>
                                                            <div class="col-4 mb-5">
                                                                <h4><?php echo e($pCat->name); ?></h4>
                                                                <hr>

                                                                <ul class="mega-menu__list">
                                                                    <?php $__currentLoopData = $pCat->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <li class="current-menu-item "><a
                                                                                    href="<?php echo e(route('category.shop',$sCat->slug)); ?>"><?php echo e($sCat->name); ?></a>
                                                                        </li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                                </ul>
                                                            </div>

                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </div>

                                            </div>

                                            <div class="card w-30">
                                                <?php $__currentLoopData = brandsShuffle(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brandShuffle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <img class="card-img-top mb-2"
                                                         src="<?php echo e(filePath($brandShuffle->logo)); ?>"
                                                         alt="#<?php echo e($brandShuffle->name); ?>">
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>

                                        </div>

                                    </li>

                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="navigation__right">
                <ul class="menu menu--recent-view">
                    <li><a href="<?php echo e(route('all.product')); ?>">All Products</a></li>
                    <?php if(vendorActive()): ?>
                        <li><a href="<?php echo e(route('vendor.shops') ?? ''); ?>">All Shops</a></li>
                        <li><a href="<?php echo e(route('brands') ?? ''); ?>">All Brands</a></li>
                    <?php endif; ?>

                    <li><a href="<?php echo e(route('customer.campaigns.index')); ?>">Campaigns</a></li>
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
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/include/header/header.blade.php ENDPATH**/ ?>