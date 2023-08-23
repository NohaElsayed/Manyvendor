{{-- form goes here --}}
@if(\Illuminate\Support\Facades\Auth::user()->user_type == 'Deliver')
    <form class="border border-light p-5" action="{{ route('deliver.order.followup_comment', $followup) }}" method="POST"
          enctype="multipart/form-data">
        @csrf
@else
            <form class="border border-light p-5" action="{{ route('order.followup_comment', $followup) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
@endif



    <label for="textarea">@translate(Write a reason for follow up).</label>
    <textarea id="textarea" name="comment" class="form-control mb-4" placeholder="Customer did not pick up the call"
              required></textarea>

    <button class="btn btn-info btn-block my-4" type="submit">@translate(Submit)</button>

</form>
{{-- form goes here::END --}}

