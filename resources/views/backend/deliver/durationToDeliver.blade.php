{{-- form goes here --}}
<form class="border border-light p-5" action="{{ route('deliver.pick.store') }}" method="POST"
      enctype="multipart/form-data">
    @csrf

    <input name="id" value="{{$deliver->id}}" type="hidden">

    <label for="textarea">@translate(Deliver within date).</label>
    <input name="duration" class="form-control" type="date" placeholder="Deliver within date" required>
    <button class="btn btn-info btn-block my-4" type="submit">@translate(Submit)</button>

</form>
{{-- form goes here::END --}}

