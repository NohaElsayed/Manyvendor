@extends('backend.layouts.master')
@section('title') @translate(Update Shipping Zone) @endsection
@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"> @translate(Edit Shipping Zone)</h3>
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
                        <form method="post" action="{{route('logistics.area.update',$single_area->id)}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div>
                                <div class="form-group">
                                    <label>@translate(Shipping Logistic)</label>
                                    <select class="form-control select2" name="logistic_id" required>
                                        <option value="">@translate(Select Logistic)</option>
                                        @foreach($logistics as $logistic)
                                            <option value="{{ $logistic->id }}"
                                                    {{ $single_area->logistic_id ==  $logistic->id ? 'selected':'' }} selected>
                                                {{ $logistic->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@translate(Select Division)</label>
                                    <input type="hidden" class="getDivisionArea"
                                           value="{{ route('get.division.area') }}">
                                    <select class="form-control select2 division" name="division_id" required>
                                        <option value=""></option>
                                        @foreach($districts as $district)
                                            <option
                                                value="{{ $district->id }}" {{ $single_area->division_id ==  $district->id ? 'selected':'' }}>{{ $district->district_name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group">

                                    <label>@translate(Select Area)</label>
                                    <select class="form-control select2 area" name="area_id[]" multiple required>
                                        @foreach(\App\Models\Thana::where('district_id',$single_area->division_id)->get() as $area)
                                        <option value="{{$area->id}}"
                                        @foreach(json_decode($single_area->area_id) as $data)
                                            {{(int)$data == $area->id ? 'selected': null}}
                                                @endforeach
                                        >
                                           {{$area->thana_name}}
                                        </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@translate(Shipping Charge)</label>
                                    <input type="number" name="rate" value="{{ $single_area->rate }}"
                                           min="0" step="0.01"  class="form-control" placeholder="Shipping Charge">
                                    <small>@translate(Shipping charge is based on their logistic company policy).</small>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>@translate(Estimated shipping days(min))</label>
                                            <input type="number" name="min" value="{{ $single_area->min }}"
                                                   min="1"  class="form-control" placeholder="Minimun days">
                                        </div>
                                        <div class="col-md-6">
                                            <label>@translate(Estimated shipping days(max))</label>
                                            <input type="number" name="max" value="{{ $single_area->max }}"
                                                  min="1" class="form-control" placeholder="Maximum days">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" id="is_active" {{$single_area->is_active == 1 ?'checked':null}} name="is_active">
                                    <label for="is_active"> @translate(Is active?)</label>
                                </div>

                                <button type="submit" class="btn btn-primary">@translate(Update)</button>

                            </div>

                        </form>
                    </div>
                </div>

            </div>

            <!-- Content starts here:END -->


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
                            <button type="submit" class="btn btn-primary">@translate(Submit)</button>


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

                                <button type="submit" class="btn btn-primary">@translate(Submit)</button>

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
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ old('name') }}" required>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" name="is_active">
                                    <label> @translate(Is active?)</label>
                                </div>

                                <button type="submit" class="btn btn-primary">@translate(Submit)</button>

                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
