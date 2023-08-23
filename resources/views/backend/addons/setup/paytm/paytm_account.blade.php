@extends('backend.layouts.master')
@section('title') Addons Manager @endsection

@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">  Addons Install Manager</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body p-2 installui">

            {{-- Addons goes here --}}

<div class="container m-auto">
  <div class="row my-4">
    <div class="col-12">
    

      <form action="{{ route('addons.paytm.account.setup') }}" 
            method="POST" 
            enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="addon_name" value="{{ $addon_name }}" required>
            <input type="hidden" name="purchase_code" value="{{ $purchase_code }}" required>

        <div class="form-row">

          <div class="form-group col-md-12">
            <label for="inputEmail4">PAYTM_ENVIRONMENT</label>
            <input type="text" name="paytm_environment" value="{{ env('PAYTM_ENVIRONMENT') }}"  class="form-control" placeholder="ENTER PAYTM ENVIRONMENT" required>
          </div>

          <div class="form-group col-md-12">
            <label for="inputEmail4">PAYTM_MERCHANT_ID</label>
            <input type="text" name="paytm_merchant_id" value="{{ env('PAYTM_MERCHANT_ID') }}"  class="form-control" placeholder="ENTER PAYTM MERCHANT ID" required>
          </div>

          <div class="form-group col-md-12">
            <label for="inputEmail4">PAYTM_MERCHANT_KEY</label>
            <input type="text" name="paytm_merchant_key" value="{{ env('PAYTM_MERCHANT_KEY') }}"  class="form-control" placeholder="ENTER PAYTM MERCHANT KEY" required>
          </div>

          <div class="form-group col-md-12">
            <label for="inputEmail4">PAYTM_MERCHANT_WEBSITE</label>
            <input type="text" name="paytm_merchant_website" value="{{ env('PAYTM_MERCHANT_WEBSITE') }}"  class="form-control" placeholder="ENTER PAYTM MERCHANT WEBSITE" required>
          </div>

          <div class="form-group col-md-12">
            <label for="inputEmail4">PAYTM_CHANNEL</label>
            <input type="text" name="paytm_channel" class="form-control" value="{{ env('PAYTM_CHANNEL') }}"  placeholder="ENTER PAYTM CHANNEL" required>
          </div>

          <div class="form-group col-md-12">
            <label for="inputEmail4">PAYTM_INDUSTRY_TYPE</label>
            <input type="text" name="paytm_industry_type" class="form-control" value="{{ env('PAYTM_INDUSTRY_TYPE') }}" placeholder="ENTER PAYTM INDUSTRY TYPE" required>
          </div>

        </div>

        <button type="submit" class="btn btn-success">Save Account</button>

      </form>


      

    </div>
  </div>
</div>


            {{-- Addons goes here::END --}}

        </div>

    </div>




@endsection