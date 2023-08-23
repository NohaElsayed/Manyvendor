@extends('backend.layouts.master')
@section('title') @translate(Addons Manager) @endsection


@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title m-2"> @translate(Addons Manager)</h3>

            <a class="btn btn-primary ml-3" href="{{ route("addons.manager.installui") }}" title="@translate(Install new addon)">
                <i class="fa fa-plus-circle"></i> @translate(Install Addon)
            </a>
        </div>

        <!-- /.card-header -->
        <div class="card-body p-2">

            {{-- Addons goes here --}}

            {{-- Installed Addon --}}

<div class="wrapper">
    @if (paytmActive())
    <h4><strong>@translate(Installed Addon)(s) ( {{ count($addons) }} )</strong></h4>
    @else
    <h4><strong>@translate(Installed Addon)(s) ( 0 )</strong></h4>
    @endif
    
    <div class="row mt-5">
 
            @forelse ($addons as $addon)
                <div class="col-4 mt-3">
                    <div class="news">
                        <figure class="article">
                            <a href="javscript:void()" onclick="forModal('{{ route('addon.preview', $addon->name) }}', '{{ strtoupper($addon->name) }}')">
                                <img src="{{ filePath($addon->image) }}" class="w-100 img-fluid rounded" alt="#{{ $addon->name }}" >
                            </a>
                        </figure>
                            <a href="{{ route('addon.status', $addon->name) }}" class="btn btn-{{ $addon->activated == 0 ? 'success' : 'danger' }} w-100">{{ $addon->activated == 0 ? 'Activate' : 'Deactivate' }}</a>
                    </div>
                </div>
                @empty
                <div class="col-12">
                        <img src="{{ filePath('no-addon-found.jpg') }}" class="w-100" alt="#No Addons Found">
                </div>
            @endforelse

    </div>
</div>

            {{-- Installed Addon::END --}}
            <hr>
            {{-- Available Addon --}}
            <div class="wrapper">
                <h4><strong>@translate(Available Addon)(s) ( <span id="addon_count"></span> )</strong></h4>

                <input type="hidden" id="sk_loading" value="{{ filePath('sk-loading.gif') }}">

                <div id="no-addons" class="text-center"></div>
                <div id="no-addons-found" class="text-center d-none">
                    <img src="{{ filePath('no-addon-found.jpg') }}" class="w-100" alt="#No Addons Found">
                </div>
                
                <div class="d-flex mt-5 row" id="available_addons"></div>
            </div>
            {{-- Available Addon::END --}}

            {{-- Addons goes here::END --}}

        </div>

    </div>

@endsection
@section('script')

<script>

$(document).ready(function(){

    var username = 'softtech-it';
    var site = 'codecanyon';
    var code = '0eZScyN9HOoPHzKSJMtWI8U1d7VwkApX';
    var sk_loading = $('#sk_loading').val(); 

    $('#no-addons').html('<img src="'+ sk_loading +'" class="w-75 mt-5" alt="#Loading">');

    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + code
        },
        url:'https://api.envato.com/v1/market/new-files-from-user:'+ username +','+ site +'.json',

        success: function( response) {
            var data = response['new-files-from-user'];
            
            var addons_count = 0;


            $('#no-addons').addClass('d-none');
            $('#no-addons-found').addClass('d-none');

            var addons = '';
        
            data.forEach(element => {

                if (element.tags.match('manyvendor add-on')) {

                 addons += '<div class="col-4 mt-3">' +
                                    '<div class="news">'+
                                        '<figure class="article">'+
                                            '<img src='+ element.live_preview_url +' class="w-100 rounded" alt="#'+ element.item +'">'+
                                    ' </figure>'+
                                        '<a href='+ element.url +' class="btn btn-primary w-100" "target=_blank">Buy Now</a>'+
                                    '</div>'+
                            '</div>'

                    addons_count += 1;
                }
            });
            
            if (addons_count > 0) {
                var addons_count = $('#addon_count').html(addons_count);
            } else {
                var addons_count = $('#addon_count').html(0);
                $('#no-addons-found').removeClass('d-none');
            }

            $('#available_addons').html(addons); 
        }
    });
});

</script>
    
@endsection
