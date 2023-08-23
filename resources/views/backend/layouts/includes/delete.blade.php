<script type="text/javascript">
    "use strict"
    function confirm_modal(delete_url) {
        jQuery('#confirm-delete').modal('show', {backdrop: 'static'});
        document.getElementById('delete_link').setAttribute('href', delete_url);
    }
</script>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">@translate(Confirmation)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body text-center">
                <p>@translate(Are you sure want to Execute this action?)</p>
            </div>
            <div class="modal-footer justify-content-center">
                <a id="delete_link" type="submit" class="btn btn-success">@translate(Confirm)</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">@translate(Cancel)</button>
            </div>
        </div>
    </div>
</div>

