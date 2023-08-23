{{-- form goes here --}}
<form class="border border-light p-5" action="{{ route('customer.complain.store') }}" method="POST"
      enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="booking_code" value="{{ $code }}">

    <p class="h4 text-center">@translate(Complain against of) #{{ $code }}</p>

    <label for="textarea">@translate(Explain your complain)*</label>
    <textarea id="textarea" name="desc" class="form-control mb-4" placeholder="@translate(Write your complain here)"
              required></textarea>

    <div class="input-group mb-4">
        <div class="input-group-prepend">
            <span class="input-group-text">@translate(Upload)</span>
        </div>
        <div class="custom-file">
            <input type="file" name="complain_photos[]" class="custom-file-input" multiple id="fileInput"
                   aria-describedby="fileInput">
            <label class="custom-file-label" for="fileInput">@translate(Upload damaged product photos)(optional)</label>
        </div>
    </div>

    <button class="btn btn-info btn-block my-4" type="submit">@translate(Submit)</button>

</form>
{{-- form goes here::END --}}

