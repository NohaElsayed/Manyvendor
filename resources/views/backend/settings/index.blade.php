@extends('backend.layouts.master')
@section('title') @translate(Section setting) @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Drag and Drop sections to change order)</h3>
        </div>

        <div class="card-vody mt-3">
            <table id="table" class="table">
                <tbody class="tablecontents row justify-content-center">
                @foreach ($sections as $section)
                    <tr class="row col-3 mx-1 bg-white" data-id="{{ $section->id }}">
                        <td class="card">
                            {{$loop->index+1}}
                            <h2 class="card-title font-weight-bold m-2"><i
                                    class="fa fa-arrows grab-icon"></i> {{$section->name}}</h2>
                            <div class="card-body">
                                <img src="{{filePath($section->image)}}" class="w-100">
                            </div>
                            <div class="card-footer">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input data-id="{{$section->id}}"
                                           {{$section->active == true ? 'checked' : null}}  data-url="{{route('section.setting.status')}}"
                                           type="checkbox" class="custom-control-input"
                                           id="customSwitch{{$section->id}}">
                                    <label class="custom-control-label" for="customSwitch{{$section->id}}"></label>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>


@endsection


@section('script')
    <script type="text/javascript">
        "use strict"
        $(document).ready(function () {
            $(".tablecontents").sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function () {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {
                var order = [];
                var token = $('meta[name="csrf-token"]').attr('content');
                $('tr.row').each(function (index, element) {
                    console.log(order);
                    order.push({
                        id: $(this).attr('data-id'),
                        sort: index + 1
                    });
                });

                $.ajax({
                    method: "GET",
                    url: "{{ route('section.setting.sort') }}",
                    data: {
                        order: order
                    },
                    success: function (response) {
                        //response goes here
                        toastr.success(response.message, toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "30000",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        });
                    }
                });
            }
        })

    </script>

@stop





