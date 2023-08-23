{{-- form goes here --}}
<p>{{ $complain_review->desc }}</p>
@if (!empty($complain_review->complain_photos))
    <div class="row p-5">
        @foreach (json_decode($complain_review->complain_photos) as $photo)
            <div class="col-md-3 text-center">
                <div class="card card-primary card-outline" style="width: 18rem;">
                    <img src="{{ filePath($photo) }}" class="card-img-top" alt="...">
                </div>
            </div>
        @endforeach
    </div>
@endif
{{-- form goes here::END --}}

