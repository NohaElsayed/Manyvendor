@extends('backend.layouts.master')
@section('title') @translate(info pages) @endsection
@section('content')

<div class="fs-16 text-info mt-1">@translate(These pages will be focused to customers in footer section)</div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2 class="card-title">@translate(Info Pages List)</h2>
                </div>
                <div class="card-body">
                    <!--begin: Datatable -->
                    <table class="table data-table table-bordered">
                        <thead>
                        <tr>
                            <th>@translate(S/L)</th>
                            <th>@translate(Header)</th>
                            <th>@translate(Action)</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($infopages as $item)
                            <tr>
                                <td>{{($loop->index+1)}}</td>
                                <td>{{$item->header}}<br><span
                                        class="badge badge-secondary">{{$item->section}}</span><br>
                                    <p>@translate(Page) : {{$item->page->title}}</p>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                                data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">@translate(Toggle Dropdown)</span>
                                        </button>
                                        <ul class="dropdown-menu  dropdown-menu-right p-2" role="menu">
                                            <li><a href="#!" class="nav-link text-black"
                                                   onclick="forModal('{{route('info.page.edit',$item->id)}}','Info Page edit')">@translate(Edit)</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li class=""><a href="#!" class="nav-link text-black"
                                                            onclick="confirm_modal('{{route('info.page.destroy',$item->id)}}')">@translate(Delete)</a>
                                            </li>
                                        </ul>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>

        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">@translate(Add Info page)</h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" enctype="multipart/form-data"
                          action="{{ route('info.page.store') }}"
                          method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="">
                                <label class="control-label">@translate(Header) <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="">
                                <input type="text" class="form-control" name="header" required
                                       placeholder="@translate(Ex: Header)">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <label class="control-label">@translate(Icon)</label>
                            </div>
                            <div class="">
                                <input type="text" class="form-control" name="icon"
                                       placeholder="@translate(Ex: Icon class only)">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <label class="control-label">@translate(Small text)</label>
                            </div>
                            <div class="">
                                <input type="text" class="form-control" name="desc"
                                       placeholder="@translate(Ex: small description)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">@translate(Select Section)</label>
                            <div class="">
                                <select class="form-control select2" name="section">
                                    <option value="top">@translate(Top Section)</option>
                                    <option value="bottom">@translate(Bottom Section)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">@translate(Select page)</label>
                            <div class="">
                                <select class="form-control select2" name="page_id">
                                    <option value=""></option>
                                    @foreach($pages as $page)
                                        <option value="{{$page->id}}"> {{$page->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-primary btn-block" type="submit">@translate(Save)
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--there are the main content-->
@endsection


