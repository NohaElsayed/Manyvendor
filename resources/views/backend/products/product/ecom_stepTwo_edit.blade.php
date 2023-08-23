@extends('backend.layouts.master')
@section('title') @translate(Product Stock) @endsection
@section('content')

	<div class="card card-primary card-outline">
		<div class="card-header">
			<h3 class="card-title"> @translate(Product Stock)</h3>

		</div>
		<!-- /.card-header -->
		<div class="card-body p-2">
			<!-- Content starts here -->
			<div class="card-body">
				<form method="post" action="{{route('product.step.tow.update')}}" enctype="multipart/form-data">
					@csrf
					<input type="hidden" class="product" value="{{$product->id}}" name="product_id">
					<div class="row">
						<div class="col-md-12 p-2">
							<div class='row m-2'>
								@if($product->variants->count() <= 0)
									{{--if no variant--}}
									@if($product->variantProductStock->first() != null)
										<input name="have_vpstock_id" type="hidden"
										       value="{{$product->variantProductStock->first()->id}}">
										<div class='form-group col-6'>
											<label>@translate(Total Quantity)</label>
											<input name='total_quantity' type='number' min='0'
											       class='form-control'
											       value="{{$product->variantProductStock->first()->quantity}}">
										</div>
										<div class='form-group col-6'>
											<label>@translate(Alert Quantity)</label>
											<input name='alert_quantity_s' min='0' type='number'
											       class='form-control'
											       value="{{$product->variantProductStock->first()->alert_quantity}}">
										</div>
									@endif
									{{--if no variant--}}

								@else

									<table class='table table-responsive-sm'>
										<tbody class=''>
										@foreach($product->variantProductStock as $productVariant)
											<tr>
												<input name="have_pv_id[]" type="hidden"
												       value="{{$productVariant->id}}">
												<td><label>@translate(Variants)</label>
													<div class="form-control text-uppercase">
														{{$productVariant->product_variants ?? '@translate(No variant)' }}
													</div>
												</td>
												<td><label>@translate(Quantity)</label><input name='have_pv_q[]'
												                                              type='number'
												                                              placeholder="@translate(Quantity)"
												                                              min='0'
												                                              class='form-control'
												                                              value="{{$productVariant->quantity}}">
												</td>
												<td><label>@translate(Extra Price)</label><input name='have_pv_price[]'
												                                                 type='number'
												                                                 placeholder="@translate(Extra Price)"
												                                                 class='form-control'
												                                                 value="{{$productVariant->extra_price}}">
												</td>
												<td><label class="">@translate(Alert Quantity)</label>
													<input name='have_pv_alert_quantity[]' type='number'
													       placeholder="@translate(Alert Quantity)" min='0'
													       class='form-control'
													       value="{{$productVariant->alert_quantity}}"></td>
											</tr>
										@endforeach
										</tbody>
									</table>
								@endif
								<div class="card w-100" id="productDetails"></div>
							</div>
						</div>
					</div>


					<div class="col-md-12">
						<div class="form-group">
							<button type="submit" class="btn btn-primary">@translate(Submit)</button>
						</div>
					</div>

				</form>
			</div>
		</div>
		<!-- Content starts here:END -->
	</div>

	<input class="productdetailsUrl" type="hidden"
	       value="{{route('admin.product.show')}}">
@endsection

@section('script')
	<script>
        "use strict"


        $(document).ready(function () {
            var url = $(".productdetailsUrl").val();
            var chooseProduct = $(".product").val();
            /*ajax get value*/
            if (url == null) {
                location.reload();
            } else {
                $.ajax({
                    url: url,
                    method: "GET",
                    data: {id: chooseProduct},
                    success: function (result) {
                        $("#productDetails").html(result);

                    },
                });
            }
        })

	</script>
@endsection
