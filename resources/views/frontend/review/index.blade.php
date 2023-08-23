

        <p class="h4 text-center">@translate(Review against of) #{{ $code }}</p>
        {{-- form goes here --}}
        @if (empty($order->review))
        <form
            class="border border-light p-5"
            action="{{ route('customer.product.review.store', $code) }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf

            <label for="textarea">@translate(Explain your product experience)*</label>

                <div class="form-group">
                    <textarea class="form-control" id="textarea" name="desc" rows="6" placeholder="Write your review here" required="required"></textarea>
                                                </div>


            <div
                class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                <input type="radio" id="star5" name="rating" value="5"/>
                <label for="star5" title="5 star">5</label>
                <input type="radio" id="star4" name="rating" value="4"/>
                <label for="star4" title="4 star">4</label>
                <input type="radio" id="star3" name="rating" value="3"/>
                <label for="star3" title="3 star">3</label>
                <input type="radio" id="star2" name="rating" value="2"/>
                <label for="star2" title="2 star">2</label>
                <input type="radio" id="star1" name="rating" value="1"/>
                <label for="star1" title="1 star">1</label>
            </div>

            <button class="btn btn-info btn-block my-4" type="submit">@translate(Submit)</button>

        </form>
        @else
        <div class="row">
            <div class="col-md-12">
                <div class="customer-rating text-center">
                    @for ($i = 0; $i < $order->review_star; $i++)
                        <span class="fa fa-star checked fs-20"></span>
                    @endfor
                </div>
                
            </div>
        </div>
        <p>{{ $order->review }}</p>
        
        @endif
        {{-- form goes here::END --}}
