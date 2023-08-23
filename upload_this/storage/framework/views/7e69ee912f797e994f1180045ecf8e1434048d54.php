<div class="ps-panel--sidebar" id="search-sidebar">
    <div class="ps-panel__header">

        <form class="ps-form--quick-search" action="<?php echo e(route('product.search')); ?>" method="get">
                    
                    <input class="form-control w-65" name="key" id="mobile_filter_input" type="text"  value="<?php echo e(Request::get('key')); ?>" placeholder="I'm shopping for...">
                    <div class="form-group--icon w-40"><i class="icon-chevron-down"></i>
                        <input type="hidden" id="mobile_filter_url" value="<?php echo e(route('header.search')); ?>">

                        <select class="form-control" name="filter_type" id="mobile_filter_type">
                            <option value="product" selected>Product</option>
                            <?php if(vendorActive()): ?>
                            <option value="shop">Shop</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                
                    <table class="table search-table" id="mobile_show_data">
                       
                    </table>

                     
                    <div class="search-table d-none">
                        <div class="row m-auto p-3" id="mobile_show_data">
                            
                        </div>
                    </div>
                

                


    </div>
    <div class="navigation__content"></div>
</div>


<script>
    /** Mobile SEARCH FILTER */
$(document).ready(function () {

    $('#mobile_filter_input').on('keyup', function () {
        var url = $('#mobile_filter_url').val();
        var type = $('#mobile_filter_type').val();
        var input = $('#mobile_filter_input').val();

        /*ajax get value*/
        if (url === null) {
            location.reload()
        } else {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    type: type,
                    input: input
                },
                success: function (result) {
                    if (input === null || input === '') {
                        $('#mobile_show_data').addClass('d-none');
                    } else {
                        $('#mobile_show_data').html(result);
                        $('#mobile_show_data').removeClass('d-none');
                    }
                }
            });


        }
    })
});
</script><?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/include/sidebar/mobile/search-bar.blade.php ENDPATH**/ ?>