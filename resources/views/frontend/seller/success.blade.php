@extends('frontend.master')


@section('title') @translate(Registration Done Successfully) @stop

@section('content')
<div class="vendor-success">
  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="card border-0">
          <img src="{{ asset('vendor-success.png') }}" alt="">
          <div class="card-body">
            <h3 class="card-title text-center">@translate(Registration Done Successfully).</h3>
            <p class="card-text text-center fs-18">@translate(Please wait for admin to approve. We will send you an email notification after approval).</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

