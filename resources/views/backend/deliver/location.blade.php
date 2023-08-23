{{-- form goes here --}}
<form class="border border-light p-5" action="{{ route('order.location.status.store') }}" method="POST"
      enctype="multipart/form-data">
    @csrf

    <input name="deliver_assign_id" value="{{$deliver->id}}" type="hidden">
    <input name="order_id" value="{{$deliver->order_id}}" type="hidden">
    <label for="textarea">@translate(Write present location).</label>
    <textarea id="textarea" name="location" class="form-control mb-4" placeholder="Add location"
              required></textarea>

    <button class="btn btn-info btn-block my-4" type="submit">@translate(Submit)</button>

</form>
{{-- form goes here::END --}}

