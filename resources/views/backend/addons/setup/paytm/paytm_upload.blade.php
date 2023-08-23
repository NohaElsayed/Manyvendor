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
        
       <form action="{{ route('addons.install.index') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" value="{{ $addon_name }}" name="addon_name" required>
            <input type="hidden" value="{{ $purchase_code }}" name="purchase_code" required>
            <input type="hidden" value="{{ $paytm_environment }}" name="paytm_environment" required>
            <input type="hidden" value="{{ $paytm_merchant_id }}" name="paytm_merchant_id" required>
            <input type="hidden" value="{{ $paytm_merchant_key }}" name="paytm_merchant_key" required>
            <input type="hidden" value="{{ $paytm_merchant_website }}" name="paytm_merchant_website" required>
            <input type="hidden" value="{{ $paytm_channel }}" name="paytm_channel" required>
            <input type="hidden" value="{{ $paytm_industry_type }}" name="paytm_industry_type" required>

        <div class="example">
        <input type="file" class="no-w-h invisible" id="files1" name="addons">
		<div id="drop_zone" onclick="dropzone=true; document.getElementById('files1').click();/*click on hidden input button onclick by this div*/">Drop files here or click to upload</div>
        <div id="progress_bar">
            <div class="percent">0%</div>
        </div>		
        <output id="file_list3"></output>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary w-50 p-3">Install Addon</button>
    </div>
        </form> 


     
      

    </div>
  </div>
</div>


            {{-- Addons goes here::END --}}

        </div>

    </div>




@endsection