@extends('backend.layouts.master')
@section('title') @translate(Variant) @endsection
@section('content')

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">@translate(Variant list)</h3>
                </div>
                <div class="card-body p-2">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>@translate(S/L)</th>
                            <th>@translate(Unit)</th>
                            <th>@translate(Type)</th>
                            <th>@translate(Action)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($variants as $variant)
                            <tr>
                                <td> {{$loop->index+1}}</td>
                                <td>{{$variant->unit}}</td>
                                <td><span class="badge badge-primary">{{$variant->variant}}</span></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                                data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu  dropdown-menu-right p-2" role="menu">
                                            <li>
                                                <a href="{{route('variants.edit', $variant->id)}}" class="nav-link text-black">@translate(Edit)</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#!" class="nav-link text-black"
                                                   onclick="confirm_modal('{{ route('variants.destroy', $variant->id) }}')">@translate(Delete)</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <h5 class="text-center">@translate(No data found)</h5>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        @if($edit == false)
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">@translate(Create Variation)</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-2">
                    <form action="{{route('variants.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label">@translate(Variant Unit)</label>
                            <select required class="form-control select2" name="unit" id="unit">
                                <option value="">@translate(Select unit)</option>
                                <option value="Size">@translate(Size)</option>
                                <option value="Color">@translate(Color)</option>
                                <option value="Fabric">@translate(Fabric)</option>
                                <option value="Wheel">@translate(Wheel)</option>
                                <option value="Weight">@translate(Weight)</option>
                                <option value="Capacity">@translate(Capacity)</option>
                                <option value="Sleeve">@translate(Sleeve)</option>
                                <option value="Lace">@translate(Lace)</option>
                                <option value="Bulbs">@translate(Bulbs)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">@translate(Variants)</label>
                            <input  type="text" name="variant" value="" class="form-control w-100">
                        </div>

                        <div class="form-group d-none code">
                            <label class="col-form-label">@translate(Color Code)</label>
                            <div class="input-group my-colorpicker2">
                                <input type="text" class="form-control" name="code">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                </div>
                            </div>
                        </div>


                        <button class="btn btn-primary" type="submit">@translate(Save)</button>
                    </form>
                </div>
            </div>


            {{-- Request Variation --}}

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">@translate(Variant Requests)</h3>
                </div>
                <div class="card-body p-2">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>@translate(S/L)</th>
                            <th>@translate(Seller)</th>
                            <th>@translate(Product)</th>
                            <th>@translate(Variation)</th>
                            <th>@translate(Action)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($variants_request as $variant_request)
                            <tr>
                                <td> {{$loop->index+1}}</td>
                                <td class="text-center">
                                    @if($variant_request->product_variant)
                                    <a target="_blank" href="{{ route('single.product',[$variant_request->product_variant->product->sku,$variant_request->product_variant->product->slug]) }}">
                                        <img class="w-40" src="{{ filePath($variant_request->product_variant->product->image) }}" alt="#{{ $variant_request->product_variant->product->name }}">
                                    </a>
                                        @endif
                                     
                                </td>
                                <td>

                                    @if($variant_request->product_variant)
                                    <a target="_blank" href="{{ route('single.product',[$variant_request->product_variant->product->sku,$variant_request->product_variant->product->slug]) }}">
                                        {{ $variant_request->product_variant->product->name }}
                                    </a>
                                        @endif
                                </td>
                                <td> {{ $variant_request->unit }} <br> {{ $variant_request->variant }}/{{ $variant_request->code }} </td>
                                <td>
                                    <a href="javascript:void(0)"
                                    onclick="forModal('{{ route('admin.variation.edit', $variant_request->id) }}', '@translate(Edit)')" 
                                    class="d-block text-primary p-1" 
                                    title="Edit">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('admin.variation.approve', $variant_request->id) }}" class="d-block text-success p-1" title="Approve">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('admin.variation.decline', $variant_request->id) }}" class="d-block text-danger p-1" title="Decline">
                                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <h5 class="text-center">@translate(No data found)</h5>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


            {{-- Request Variation::END --}}


        </div>


        



        @else
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">@translate(Update Variant)</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-2">
                    <form action="{{route('variants.update')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$var->id}}">
                        <div class="form-group">
                            <label class="col-form-label">@translate(Variant Unit)</label>
                            <select required class="form-control select2" name="unit" id="unit">
                                <option value="">@translate(Select unit)</option>
                                <option value="Size" {{$var->unit == "Size" ? 'selected' : null}}>@translate(Size)</option>
                                <option value="Color"  {{$var->unit == "Color" ? 'selected' : null}}>@translate(Color)</option>
                                <option value="Fabric" {{$var->unit == "Fabric" ? 'selected' : null}}>@translate(Fabric)</option>
                                <option value="Wheel" {{$var->unit == "Wheel" ? 'selected' : null}}>@translate(Wheel)</option>
                                <option value="Weight" {{$var->unit == "Weight" ? 'selected' : null}}>@translate(Weight)</option>
                                <option value="Capacity" {{$var->unit == "Capacity" ? 'selected' : null}}>@translate(Capacity)</option>
                                <option value="Sleeve" {{$var->unit == "Sleeve" ? 'selected' : null}}>@translate(Sleeve)</option>
                                <option value="Lace" {{$var->unit == "Lace" ? 'selected' : null}}>@translate(Lace)</option>
                                <option value="Bulbs" {{$var->unit == "Bulbs" ? 'selected' : null}}>@translate(Bulbs)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">@translate(Variants)</label>
                            <input id="tags-input" type="text" name="variant" value="{{$var->variant}}" class="form-control w-100">
                        </div>


                        <div class="form-group code {{$var->code == null?  'd-none':null}}">
                            <label class="col-form-label">@translate(Color Code)</label>
                            <div class="input-group my-colorpicker2">
                                <input type="text" class="form-control" name="code" value="{{$var->code}}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-square" style="color: {{$var->code}}"></i></span>
                                </div>
                            </div>
                        </div>


                        <button class="btn btn-primary" type="submit">@translate(Save)</button>
                    </form>

                </div>
            </div>
        </div>
        @endif
    </div>



@endsection

@section('script')
    <script>
        "use strict"
        $("#unit").change(function(){
            var unit = $(this). children("option:selected"). val();
            if(unit==='Color'){
                $('.code').removeClass('d-none')
            }else{
                $('.code').addClass('d-none')
            }

        });
    </script>
@endsection

