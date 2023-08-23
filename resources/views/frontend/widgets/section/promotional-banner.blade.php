<div class="ps-home-ads p-bottom-30">
    <div class="container">
        <div class="row">

          @foreach(getPromotions('section') as $section)
            <div class="col-lg-4 col-12 mb-3 mb-lg-0">
              <a class="ps-collection" href="{{ $section->link }}">
                <img src="{{ filePath($section->image) }}" alt="">
              </a>
            </div>
          @endforeach

        </div>
    </div>
</div>
