    
@if (getPopup('popup'))
<div class="modal fade text-center py-5 subscribeModal-lg"  id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered m-auto modal-lg my-new-popup" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <div class="ps-popup__content bg--cover">
        <a href="{{ getPopup('popup')->link }}">
            <img src="{{ filePath(getPopup('popup')->image) }}" alt="#popup" class="img-fluid w-100">
        </a>
        <a class="ps-popup__close" href="javascrip:void();" data-dismiss="modal">
            <i class="icon-cross"></i>
        </a>
    </div>
                
            </div>
        </div>
    </div>
</div>
@endif