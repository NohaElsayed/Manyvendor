<div class="card">
	<div class="card-header text-center p-4">
		<span class="bg-danger py-2 px-5 text-white rounded"> @translate(Are you sure want to delete this request)?</span>
	</div>
	<div class="card-body">
		<form action="{{route('customers.affiliate.deleteRequest', $req->id)}}" method="post" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="id" value="{{$req->id}}">
			<div class="text-center">
				<button type="submit" class="btn btn-danger px-5 py-3">@translate(Delete)</button><br><br>
				<small class="text-primary">@translate(Amount will be added to  balance)</small>
			</div>
		</form>

	</div>
</div>
