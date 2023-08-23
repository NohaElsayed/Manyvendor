
<input type="hidden" class="app_url" value="<?php echo e(env('APP_URL')); ?>">


<input type="hidden" class="cart-list-url" value="<?php echo e(route('cart.list')); ?>">
<input type="hidden" class="update-to-cart" value="<?php echo e(route('update.to.cart')); ?>">
<input type="hidden" class="add-to-cart-url" value="<?php echo e(route('add.to.cart')); ?>">
<input type="hidden" class="remove-from-cart-url" value="<?php echo e(route('remove.from.cart')); ?>">
<input type="hidden" class="cart-empty" value="<?php echo e(asset('emptycart.png')); ?>">


<input type="hidden" class="wishlist-url" value="<?php echo e(route('wishlists')); ?>">
<input type="hidden" class="wishlists-index" value="<?php echo e(route('wishlists.index')); ?>">
<input type="hidden" class="add-to-wishlist-url" value="<?php echo e(route('add.to.wishlist')); ?>">
<input type="hidden" class="go-to-auth" value="<?php echo e(route('login-redirect')); ?>?url=<?php echo e(url()->current()); ?>">
<input type="hidden" class="remove-from-wishlist-url" value="<?php echo e(route('remove.from.wishlist')); ?>">
<input type="hidden" class="wishlist-empty" value="<?php echo e(asset('wishlist.png')); ?>">


<input type="hidden" class="compare-list-url" value="<?php echo e(route('compare.list')); ?>">
<input type="hidden" class="compare-empty" value="<?php echo e(asset('comparison.png')); ?>">



<input type="hidden" class="guest-cart-list-url" value="<?php echo e(route('guest.cart.list')); ?>">
<input type="hidden" class="guest-remove-from-cart-url" value="<?php echo e(route('guest.remove.from.cart')); ?>">
<input type="hidden" class="guest-cart-empty" value="<?php echo e(asset('emptycart.png')); ?>">
<input type="hidden" class="guest-shopping-cart" value="<?php echo e(asset('guest.shopping.cart.blade')); ?>">

<input type="hidden" class="auth-check" value="<?php if(auth()->guard()->check()): ?> 1 <?php endif; ?> <?php if(auth()->guard()->guest()): ?> 0 <?php endif; ?>"> 
<input type="hidden" class="is-active-guest-checkout" value="<?php echo e(env('GUEST_CHECKOUT')); ?>"> 


<input type="hidden" class="get-checkout-data" value="<?php echo e(route('checkout.get.data')); ?>">



    <?php if(Auth::check()): ?>
        <input type="hidden" class="auth-check" value="loggedIn">
    <?php else: ?>
        <input type="hidden" class="auth-check" value="loggedOut">
    <?php endif; ?><?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/assets/url.blade.php ENDPATH**/ ?>