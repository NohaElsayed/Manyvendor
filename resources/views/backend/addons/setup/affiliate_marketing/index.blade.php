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

      <form action="{{ route('addons.purchase_code.verify','affiliate_marketing') }}"
            method="POST" 
            enctype="multipart/form-data">
            @csrf
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="inputEmail4">ITEM PURCHASE CODE <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="The product purchase code is given from codecanyon, when you bought the application."> <i class="fa fa-info-circle" aria-hidden="true"></i></a> </label>
            <input type="hidden" name="addon_name" value="{{ $addon }}">
            <input type="text" placeholder="PRODUCT PURCHASE CODE" name="purchase_code" class="form-control purchase_code" placeholder="Enter your purchase code" required>
          </div>
        
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-success w-25 btn-purchase_code">Verify Product</button>
        </div>


      </form>


      

    </div>
  </div>
</div>


            {{-- Addons goes here::END --}}

        </div>

    </div>




@endsection