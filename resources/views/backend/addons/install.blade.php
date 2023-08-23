@extends('backend.layouts.master')
@section('title') Addons Manager @endsection

@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Addons Install Manager</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body p-2 installui">

            {{-- Addons goes here --}}

<div class="container m-auto">
  <div class="row my-4">
      
    <div class="col-3">
        <a href="{{ route('addon.setup', 'paytm') }}">
            <div class="card setup-card">
                <img class="card-img-top setup-card-img" src="{{ filePath('paytm-thumb.png') }}" alt="#paytm">
            </div>
        </a>
    </div>


    <div class="col-3">
        <a href="{{ route('addon.setup', 'product_export_import') }}">
            <div class="card setup-card">
                <img class="card-img-top setup-card-img" src="{{ filePath('product-ex-im-thumb.png') }}" alt="#product_export_import">
            </div>
        </a>
    </div>


    <div class="col-3">
        <a href="{{ route('addon.setup', 'ssl_commerz') }}">
            <div class="card setup-card">
                <img class="card-img-top setup-card-img" src="{{ filePath('ssl-commerz-thumb.png') }}" alt="#ssl_commerz">
            </div>
        </a>
    </div>


     <div class="col-3">
      <a href="{{ route('addon.setup', 'affiliate_marketing') }}">
          <div class="card setup-card">
              <img class="card-img-top setup-card-img" src="{{ filePath('affiliate-thumb.png') }}" alt="#affiliate_marketing">
          </div>
      </a>
  </div>


  
</div>
</div>


            {{-- Addons goes here::END --}}

        </div>

    </div>


@endsection