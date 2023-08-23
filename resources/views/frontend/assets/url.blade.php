{{--App url for ajax--}}
<input type="hidden" class="app_url" value="{{env('APP_URL')}}">

{{--cart ajax url--}}
<input type="hidden" class="cart-list-url" value="{{route('cart.list')}}">
<input type="hidden" class="update-to-cart" value="{{route('update.to.cart')}}">
<input type="hidden" class="add-to-cart-url" value="{{route('add.to.cart')}}">
<input type="hidden" class="remove-from-cart-url" value="{{route('remove.from.cart')}}">
<input type="hidden" class="cart-empty" value="{{asset('emptycart.png')}}">

{{--wishlist ajax url--}}
<input type="hidden" class="wishlist-url" value="{{route('wishlists')}}">
<input type="hidden" class="wishlists-index" value="{{route('wishlists.index')}}">
<input type="hidden" class="add-to-wishlist-url" value="{{route('add.to.wishlist')}}">
<input type="hidden" class="go-to-auth" value="{{route('login-redirect')}}?url={{url()->current()}}">
<input type="hidden" class="remove-from-wishlist-url" value="{{route('remove.from.wishlist')}}">
<input type="hidden" class="wishlist-empty" value="{{asset('wishlist.png')}}">

{{--compare ajax url--}}
<input type="hidden" class="compare-list-url" value="{{route('compare.list')}}">
<input type="hidden" class="compare-empty" value="{{asset('comparison.png')}}">


{{--guest cart ajax url--}}
<input type="hidden" class="guest-cart-list-url" value="{{route('guest.cart.list')}}">
<input type="hidden" class="guest-remove-from-cart-url" value="{{route('guest.remove.from.cart')}}">
<input type="hidden" class="guest-cart-empty" value="{{asset('emptycart.png')}}">
<input type="hidden" class="guest-shopping-cart" value="{{asset('guest.shopping.cart.blade')}}">

<input type="hidden" class="auth-check" value="@auth 1 @endauth @guest 0 @endguest"> {{--Auth check url--}}
<input type="hidden" class="is-active-guest-checkout" value="{{env('GUEST_CHECKOUT')}}"> {{--guest checkout check url--}}

{{--checkout data ajax url--}}
<input type="hidden" class="get-checkout-data" value="{{route('checkout.get.data')}}">

{{-- Auth check --}}

    @if (Auth::check())
        <input type="hidden" class="auth-check" value="loggedIn">
    @else
        <input type="hidden" class="auth-check" value="loggedOut">
    @endif