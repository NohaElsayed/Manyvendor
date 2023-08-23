<div class="ps-panel--sidebar" id="search-sidebar">
    <div class="ps-panel__header">

        <form class="ps-form--quick-search" action="{{route('product.search')}}" method="get">
                    
                    <input class="form-control w-65" name="key" id="mobile_filter_input" type="text"  value="{{Request::get('key')}}" placeholder="I'm shopping for...">
                    <div class="form-group--icon w-40"><i class="icon-chevron-down"></i>
                        <input type="hidden" id="mobile_filter_url" value="{{ route('header.search') }}">

                        <select class="form-control" name="filter_type" id="mobile_filter_type">
                            <option value="product" selected>@translate(Product)</option>
                            @if(vendorActive())
                            <option value="shop">@translate(Shop)</option>
                            @endif
                        </select>
                    </div>
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                {{-- Search result --}}
                    <table class="table search-table" id="mobile_show_data">
                       
                    </table>

                     {{-- Search result --}}
                    <div class="search-table d-none">
                        <div class="row m-auto p-3" id="mobile_show_data">
                            {{-- Data goes here --}}
                        </div>
                    </div>
                {{-- Search result:END --}}

                {{-- Search result:END --}}


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
</script>