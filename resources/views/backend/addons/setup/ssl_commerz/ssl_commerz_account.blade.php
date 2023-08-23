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
    

      <form action="{{ route('addons.ssl.account.setup') }}" 
            method="POST" 
            enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="addon_name" value="{{ $addon_name }}" required>
            <input type="hidden" name="purchase_code" value="{{ $purchase_code }}" required>

        <div class="form-row">

          <div class="form-group col-md-12">
            <label for="inputEmail4">SSL COMMERZ STORE ID</label>
            <input type="text" name="ssl_store_id" class="form-control" placeholder="Enter your store id" required>
          </div>

          <div class="form-group col-md-12">
            <label for="inputEmail4">SSL COMMERZ PASSWORD</label>
            <input type="text" name="ssl_store_password" class="form-control" placeholder="Enter your store password" required>
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