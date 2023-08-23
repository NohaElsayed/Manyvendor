@extends('frontend.master')

@section('title') @translate(Shopping Cart) @stop

@section('content')

<div class="ps-page--simple">
  <div class="ps-breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
            <li>@translate(Shopping Cart)</li>
        </ul>
    </div>
  </div>
  <div class="ps-section--shopping ps-shopping-cart">
      <div class="container">
          <div class="ps-section__header">
              <h1>@translate(Shopping Cart)</h1>
          </div>
          <div class="ps-section__content">
              <div class="table-responsive">
                  <table class="table ps-table--shopping-cart text-center">
                      <thead>
                          <tr>
                              <th>@translate(Product name)</th>
                              <th>@translate(PRICE)</th>
                              <th>@translate(QUANTITY)</th>
                              <th>@translate(TOTAL)</th>
                              <th></th>
                          </tr>
                      </thead>

                      <tbody class="guest-cart-blade">
                        {{--data coming from ajax--}}
                      </tbody>

                  </table>
              </div>
             </div>
          <div class="ps-section__footer" data-select2-id="6">
              <div class="row">
                  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 offset-md-8">
                      <div class="ps-block--shopping-total">
                          <div class="ps-block__content">
                              @if(guestCheckout())
                                  <h3 class="d-flex justify-content-between">
                                      <span class="text-dark">@translate(Sub Total)</span>
                                      <span class="total_update_price ml-5">
                                    </span>
                                  </h3>
                                  <h3 class="d-flex justify-content-between">
                                      <span class="text-dark">@translate(Tax)</span>
                                      <span class="total_update_tax ml-5">
                                    </span>
                                  </h3>
                                  <hr/>
                                  <h3 class="d-flex justify-content-between">
                                      <span class="text-dark">@translate(Total)</span>
                                      <span class="total_update_total ml-5">

                                    </span>
                                  </h3>
                              @else
                                <h3 class="d-flex justify-content-between">
                                    <span class="text-dark">@translate(Sub Total)</span>
                                    <span class="total_update_price ml-5">
                                      {{$total_price}}
                                    </span>
                                </h3>
                                  <h3 class="d-flex justify-content-between">
                                      <span class="text-dark">@translate(Tax)</span>
                                      <span class="total_update_tax ml-5">
                                      {{$total_tax}}
                                    </span>
                                  </h3>
                                  <hr/>
                                  <h3 class="d-flex justify-content-between">
                                      <span class="text-dark">@translate(Total)</span>
                                      <span class="total_update_total ml-5">

                                    </span>
                                  </h3>
                                  @endif

                          </div>
                      </div>



                      <a class="ps-btn ps-btn--fullwidth" href="{{ route('checkout.index') }}">@translate(Proceed to checkout)</a>

                    </div>
              </div>
          </div>
      </div>
  </div>
</div>
@stop

@section('js')
{{-- js goes here --}}
    <script>
        "use strict"
        $(document).ready(function (){
            //
        });
    </script>
@stop
