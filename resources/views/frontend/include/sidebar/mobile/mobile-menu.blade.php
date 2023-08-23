<div class="ps-panel--sidebar" id="menu-mobile">
    <div class="ps-panel__header">
        <h3>@translate(Menu)</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
            @if(vendorActive())
                <li><a href="{{ route('all.product') }}">@translate(All Products)</a></li>
                <li><a href="{{ route('vendor.shops') }}">@translate(All Shops)</a></li>
                <li><a href="{{ route('brands') }}">@translate(All Brands)</a></li>
                <li><a href="{{ route('customer.campaigns.index') }}">@translate(Campaigns)</a></li>
                <li><a href="{{ route('vendor.signup') }}">@translate(Be a seller)</a></li>
                @if(affiliateRoute() && affiliateActive())
                    @auth
                        @if(Auth::user()->user_type != "Admin" && Auth::user()->user_type != "Vendor")
                            <li><a href="{{ route('customers.affiliate.registration') }}">@translate(Affiliate Marketing)</a></li>
                        @endif
                    @endauth
                    @guest
                        <li><a href="{{ route('customers.affiliate.registration') }}">@translate(Affiliate Marketing)</a></li>
                    @endguest
                @endif
            @else
                <li><a href="{{ route('all.product') }}">@translate(All Products)</a></li>
                <li><a href="{{ route('customer.campaigns.index') }}">@translate(Campaigns)</a></li>
                @if(affiliateRoute() && affiliateActive())
                    @auth
                        @if(Auth::user()->user_type != "Admin" && Auth::user()->user_type != "Vendor")
                            <li><a href="{{ route('customers.affiliate.registration') }}">@translate(Affiliate Marketing)</a></li>
                        @endif
                    @endauth
                    @guest
                        <li><a href="{{ route('customers.affiliate.registration') }}">@translate(Affiliate Marketing)</a></li>
                    @endguest
                @endif
            @endif
        </ul>
    </div>
</div>
