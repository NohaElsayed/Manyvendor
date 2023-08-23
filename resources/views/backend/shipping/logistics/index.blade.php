@extends('backend.layouts.master')
@section('title') @translate(Logistics) @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"> @translate(Logistics)</h3>
            <div class="float-right">
                <a class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleLogisticsCenter">
                    @translate(Add Logistic Company)
                </a>
            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@translate(Shipping Informations)</h3>
        </div>
        <div class="card-body p-2">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@translate(S/L)</th>
                    <th>@translate(Logistics)</th>
                    <th>@translate(Status)</th>
                    <th>@translate(Signed at)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>

                @forelse($logistics as $logistic)
                    <tr>
                        <td>{{ $loop->index++ + 1 }}</td>
                        <td>{{ $logistic->name }}</td>
                        <td>
                            <div class="form-group">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input data-id="{{$logistic->id}}"
                                           {{$logistic->is_active == true ? 'checked' : null}}  data-url="{{route('logistic.activation')}}"
                                           type="checkbox" class="custom-control-input logistic_activation"
                                           id="is_active_{{$logistic->id}}">
                                    <label class="custom-control-label" for="is_active_{{$logistic->id}}"></label>
                                </div>
                            </div>
                        </td>
                        <td>{{ $logistic->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                        data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">@translate(Toggle Dropdown)</span>
                                </button>
                                <ul class="dropdown-menu  dropdown-menu-right p-2" role="menu">
{{--                                    <li>--}}
{{--                                        <a class="nav-link text-black"--}}
{{--                                           href="{{route('logistics.area.edit', $logistic->id)}}">@translate(Edit)</a>--}}
{{--                                    </li>--}}
                                    <li class="divider"></li>
                                    <li><a href="#!" class="nav-link text-black"
                                           onclick="confirm_modal('{{ route('logistics.destroy', $logistic->id) }}')">@translate(Delete)</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <td colspan="7" class="text-center">
                        @translate(No Data Found)
                    </td>
                @endforelse

                </tbody>

            </table>
        </div>
    </div>

    <!-- MODALS -->

    <div class="modal fade" id="exampleLogisticsCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@translate(Add Logistic Company)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('logistic.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="form-group">
                                <label for="name">@translate(Company Name)</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" id="is_active" name="is_active">
                                <label for="is_active"> @translate(Is active?)</label>
                            </div>

                            <button type="submit" class="btn btn-primary">@translate(Save)</button>

                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
