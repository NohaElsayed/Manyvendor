<div class="m-3">
    <div class="row">
        @foreach($pstock as $product)
            <div class="col-lg-3 col-md-3 col-sm-12 ">
                <div class="card p-2">
                    <div class="card-body">
                        <h4>{{\Illuminate\Support\Str::upper($product->product_variants)}}</h4>
                        <p>@translate(Extra price) {{formatPrice($product->extra_price)}}</p>
                        <p>@translate(Stock ) {{$product->quantity}}</p>
                        <figure>
                            <figcaption>@translate(Quantity)</figcaption>
                            <div class="value-button" id="{{ $product->id }}" onclick="decreaseValueCamp(this)"
                                 value="Decrease Value">-
                            </div>

                            <input type="number"
                                   id="number{{ $product->id }}"
                                   value="1"
                                   min="1"
                                   max="{{$product->quantity}}"
                                   data-max="{{$product->quantity}}"
                                   class="cart-quantity-{{$product->id}} input-number camp-steps"
                                   readonly
                            />
                            <div class="value-button" id="{{ $product->id }}" onclick="increaseValueCamp(this)"
                                 value="Increase Value">+
                            </div>
                        </figure>
                    </div>
                    <div class="card-body">
                        @auth()
                            <div class="card-footer text-center border-top-0">
                                <a href="#"
                                   class="btn btn-primary m-2 p-3 fs-12 addToCart-{{$product->id}}"
                                   onclick="addToCart('{{$product->id}}','{{$campaign_id}}')">@translate(Buy Now)</a>
                            </div>
                        @endauth
                        @guest()
                                <div class="card-footer text-center border-top-0">
                                    <a href="#"
                                       class="btn btn-primary m-2 p-3 fs-12 addToCart-{{$product->id}}"
                                       onclick="addToGuestCart('{{$product->id}}','{{$campaign_id}}')">@translate(Buy Now)</a>
                                </div>
                        @endguest
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
