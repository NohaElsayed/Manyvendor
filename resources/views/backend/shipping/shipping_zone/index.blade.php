@extends('backend.layouts.master')
@section('title') @translate(Shipping Zone) @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"> @translate(Shipping Zone)</h3>
            <div class="float-right">
                <a class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleModalCenter">
                    @translate(Add Division)
                </a>

                <a class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleShippingCenter">
                    @translate(Add Shipping Area)
                </a>

                <a class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleLogisticsCenter">
                    @translate(Add Logistic Company)
                </a>

            </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body p-2">


            <!-- Content starts here -->
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card-body">
                        <form method="post" action="{{route('logistics.area.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div>

                                <div class="form-group">
                                    <label>@translate(Shipping Logistic)</label>
                                    <select class="form-control select2" name="logistic_id" required>
                                        <option value="">@translate(Shipping Logistic)</option>
                                        @foreach($logistics as $logistic)
                                            <option value="{{ $logistic->id }}">{{ $logistic->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@translate(Select Division)</label>
                                    <input type="hidden" class="getDivisionArea"
                                           value="{{ route('get.division.area') }}">
                                    <select class="form-control select2 division" name="division_id" required>
                                        <option value="">@translate(Select Division)</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->district_name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@translate(Select Area)</label>
                                    <select class="form-control select2 area" name="area_id[]" multiple required></select>
                                </div>

                                <div class="form-group">
                                    <label>@translate(Shipping Charge)</label>
                                    <input type="number" name="rate" value="{{ old('rate') }}" class="form-control"
                                           min="0" step="0.01" placeholder="Shipping Charge">
                                    <small>@translate(Shipping charge is based on their logistic company policy)</small>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>@translate(Estimated shipping days(min))</label>
                                            <input type="number" name="min" value="{{ old('min') }}"
                                                   min="1" class="form-control" placeholder="Minimun days">
                                        </div>
                                        <div class="col-md-6">
                                            <label>@translate(Estimated shipping days(max))</label>
                                            <input type="number" name="max" value="{{ old('max') }}"
                                                   min="1" class="form-control" placeholder="Maximum days">
                                        </div>
                                    </div>
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

            <!-- Content starts here:END -->


        </div>

    </div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Shipping Informations)</h3>
        </div>
        <div class="card-body p-2">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@translate(S/L)</th>
                    <th>@translate(Logistics)</th>
                    <th>@translate(Division)</th>
                    <th>@translate(Areas)</th>
                    <th>@translate(Charge)</th>
                    <th>@translate(Delivery Time(min-max))</th>
                    <th>@translate(Status)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>

                @forelse($logistic_areas as $logistic_area)
                    <tr>
                        <td>{{ $loop->index++ + 1 }}</td>
                        <td>{{ $logistic_area->logistic->name }}</td>
                        <td><span class="badge badge-primary">{{ $logistic_area->division->district_name }}</span></td>
                        <td>
                            @foreach(json_decode($logistic_area->area_id) as $data)
                                <span class="badge badge-primary">
                                          {{App\Models\Thana::where('id',$data)->first()->thana_name}}</span>
                            @endforeach
                        </td>
                        <td>{{ $logistic_area->rate }}</td>
                        <td>{{ $logistic_area->min }} - {{ $logistic_area->max }} @translate(days)</td>
                        <td>
                            <div class="form-group">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input data-id="{{$logistic_area->id}}"
                                           {{$logistic_area->is_active == true ? 'checked' : null}}  data-url="{{route('logistic.area.activation')}}"
                                           type="checkbox" class="custom-control-input is_active"
                                           id="is_active_{{$logistic_area->id}}">
                                    <label class="custom-control-label" for="is_active_{{$logistic_area->id}}"></label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                        data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">@translate(Toggle Dropdown)</span>
                                </button>
                                <ul class="dropdown-menu  dropdown-menu-right p-2" role="menu">
                                    <li>
                                        <a class="nav-link text-black"
                                           href="{{route('logistics.area.edit', $logistic_area->id)}}">@translate(Edit)</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="#!" class="nav-link text-black"
                                           onclick="confirm_modal('{{ route('logistics.area.destroy', $logistic_area->id) }}')">@translate(Delete)</a>
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
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@translate(Add Division)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('shipping.zone.division.create')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>@translate(Add Division)</label>
                            <input type="text" class="form-control" name="division_name"
                                   value="{{ old('division_name') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">@translate(Save)</button>


                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleShippingCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@translate(Add Shipping Area)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('shipping.zone.create')}}" enctype="multipart/form-data">
                        @csrf
                        <div>

                            <div class="form-group">
                                <label>@translate(Select Division)</label>
                                <select class="form-control select2" name="division_id" required>
                                    <option value=""></option>
                                    <option value="0">@translate(Select Division)</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->district_name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <label>@translate(Add Area)</label>
                                <input type="text" class="form-control" name="thana_name"
                                       value="{{ old('thana_name') }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">@translate(Save)</button>

                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
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
                                <input type="checkbox" id="is_active_logistic" name="is_active">
                                <label for="is_active_logistic"> @translate(Is active?)</label>
                            </div>
                            <button type="submit" class="btn btn-primary">@translate(Save)</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
