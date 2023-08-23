@extends('backend.layouts.master')
@section('title') @translate(Currency) @endsection
@section('content')

    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card m-2">
                <div class="card-header">
                    <h2 class="card-title">@translate(Setup Currency Setting)</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('currencies.default')}}">
                        @csrf

                        <label class="label">@translate(Select Default)</label>
                        <input type="hidden" value="default_currencies" name="type_default">
                        <select class="form-control select2" name="default">
                            <option value=""></option>
                            @foreach($dCurrencies as $item)
                                <option
                                    value="{{$item->id}}" {{getSystemSetting('default_currencies') == $item->id ? 'selected' : null}}>{{$item->symbol}} {{$item->code}}</option>
                            @endforeach
                        </select>
                        <div class="m-2 text-center">
                            <button class="btn btn-primary" type="submit">@translate(Save)</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">@translate(Currency List)</h2>
            </div>
            <div class="float-right">
                <a href="javascript:void(0)"
                   onclick="forModal('{{route("currencies.create") }}','@translate(Create Currency)')"
                   class="btn btn-primary">
                    <i class="la la-plus"></i>
                    @translate(Create A Currency)
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- there are the main content-->
            <table class="table table-striped- table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@translate(Name)</th>
                    <th>@translate(Symbol)</th>
                    <th>@translate(Code)</th>
                    <th>@translate(Flag)</th>
                    <th>@translate(Rate)</th>
                    <th>@translate(Align)</th>
                    <th>@translate(Publish)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>
                @forelse($currencies as $item)
                    <tr>

                        <td>{{$loop->index+1}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->symbol}}</td>
                        <td>{{$item->code}}</td>
                        <td>
                            <img
                                src="{{asset('images/lang/'.$item->image)}}" class="" height="30px"
                                alt=""/>
                        </td>
                        <td>{{$item->rate}}</td>
                        <td class="pt-0">


                            <div class="mid pt-0">
                                <label class="rocker rocker-small mt-0">
                                    <input type="checkbox" data-id="{{$item->id}}"
                                           data-url="{{route('currencies.align')}}" {{$item->align == true ? 'checked':null}}>
                                    <span class="switch-left">@translate(Left)</span>
                                    <span class="switch-right">@translate(Right)</span>
                                </label>
                            </div>

                        </td>
                        <td>
                            <div class="form-group">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input data-id="{{$item->id}}"
                                           {{$item->is_published == true ? 'checked':null}}  data-url="{{route('currencies.published')}}"
                                           type="checkbox" class="custom-control-input"
                                           id="customSwitch{{$item->id}}">
                                    <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group-vertical">
                                @if($item->id != 1)
                                <a class="btn btn-info"
                                   href="#!"
                                   onclick="confirm_modal('{{ route('currencies.destroy', $item->id) }}')">@translate(Delete)</a>
                                @endif
                                <a class="btn btn-warning" href="#!"
                                   onclick="forModal('{{ route('currencies.edit', $item->id) }}','@translate(Currency Update)')">
                                    @translate(Edit)</a>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"><h3 class="text-center">@translate(No data Found)</h3></td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>

@endsection
