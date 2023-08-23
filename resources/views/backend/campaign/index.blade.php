@extends('backend.layouts.master')
@section('title') @translate(Campaigns)
@endsection
@section('parentPageTitle', 'All Campaigns')
@section('content')
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">@translate(Campaigns List)</h2>
            </div>
            <div class="float-right">
                <div class="row text-right">
                    <div class="col-7">
                        <form action="{{route('admin.campaign.search')}}" method="get">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="search" class="form-control col-12"
                                       placeholder="@translate(Title / Offer)" value="{{Request::get('search')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">@translate(Search)</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-5">
                        <a href="#!"
                           onclick="forModal('{{ route('admin.campaign.create') }}', '@translate(Create Campaign)')"
                           class="btn btn-primary">
                            <i class="la la-plus"></i>
                            @translate(Add New Campaign)
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="">
                <table class="table table-striped table-bordered table-hover text-center table-sm">
                    <thead>
                    <tr>
                        <th>@translate(S/L)</th>
                        <th>@translate(Title)</th>
                        <th>@translate(Banner)</th>
                        <th>@translate(Offer)</th>
                        <th>@translate(Duration)</th>
                        <th>@translate(Seller)</th>
                        <th>@translate(Customer)</th>
                        <th>@translate(Action)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($campaigns as $item)
                        <tr>
                            <td>{{ ($loop->index+1) + ($campaigns->currentPage() - 1)*$campaigns->perPage() }}</td>
                            <td class="{{$item->end_at < \Carbon\Carbon::now()->format('Y-m-d') ? "text-danger" : "" }}">{{$item->title}}</td>

                            <td>
                                @if($item->banner != null)
                                    <img src="{{filePath($item->banner)}}"
                                         class="img-thumbnail table-avatar" alt="{{$item->name}}">
                                @endif
                            </td>


                            <td>{{$item->offer}}%</td>
                            <td>({{\Carbon\Carbon::parse($item->start_from)->format('d F, Y')}}) -
                                ({{\Carbon\Carbon::parse($item->end_at)->format('d F, Y')}})
                            </td>

                            <td>
                                <div class="form-group">
                                    <div
                                        class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input data-id="{{$item->id}}"
                                               {{$item->active_for_seller == true ? 'checked' : null}}  data-url="{{route('admin.campaign.sellerPublished')}}"
                                               type="checkbox" class="custom-control-input"
                                               id="is_published_seller{{$item->id}}">
                                        <label class="custom-control-label"
                                               for="is_published_seller{{$item->id}}"></label>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="form-group">
                                    <div
                                        class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input data-id="{{$item->id}}"
                                               {{$item->active_for_customer == true ? 'checked' : null}}  data-url="{{route('admin.campaign.customerPublished')}}"
                                               type="checkbox" class="custom-control-input"
                                               id="is_published_customer{{$item->id}}">
                                        <label class="custom-control-label"
                                               for="is_published_customer{{$item->id}}"></label>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                            data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu  dropdown-menu-right" role="menu">

                                        @if(!vendorActive())
                                            <li>
                                                <a href="{{route('admin.campaign.products', $item->slug)}}"
                                                   class="nav-link text-black">
                                                    @translate(Add Products)
                                                </a>
                                            </li>
                                        @endif

                                        @if($item->end_at < \Carbon\Carbon::now())
                                            <li>
                                                <a href="#!" class="nav-link text-success"
                                                   onclick="forModal('{{ route('admin.campaign.reCampaignEdit', $item->id) }}', '@translate(Re-campaign)')">@translate(Re-campaign)
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <button class="btn text-danger" title="This campaign is live." disabled>
                                                    @translate(Re-campaign)
                                                </button>
                                            </li>
                                        @endif

                                        <li>
                                            <a href="#!" class="nav-link text-black"
                                               onclick="forModal('{{ route('admin.campaign.edit', $item->id) }}', '@translate(Edit Campaign)')">@translate(Edit)
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#!" class="nav-link text-black"
                                               onclick="confirm_modal('{{ route('admin.campaign.destroy', $item->id) }}')">@translate(Delete)
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"><h3 class="text-center">@translate(No Data Found)</h3></td>
                        </tr>
                    @endforelse
                    </tbody>
                    <div class="float-left">
                        {{ $campaigns->links() }}
                    </div>
                </table>
            </div>
        </div>
    </div>


    @if(vendorActive())
        <div class="card m-2">
            <div class="card-header">
                <div class="float-left">
                    <h2 class="card-title">@translate(Requested by seller)</h2>
                </div>
            </div>

            <div class="card-body">
                <div class="">
                    <table class="table table-striped table-bordered table-hover text-center table-sm">
                        <thead>
                        <tr>
                            <th>@translate(S/L)</th>
                            <th>@translate(Title)</th>
                            <th>@translate(Banner)</th>
                            <th>@translate(Offer)</th>
                            <th>@translate(Duration)</th>
                            <th>@translate(Action)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse(\App\Models\Campaign::where('is_requested', '!=','null')->get() as $reqItem)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$reqItem->title}}</td>

                                <td>
                                    @if($reqItem->banner != null)
                                        <img src="{{filePath($reqItem->banner)}}"
                                             class="img-thumbnail table-avatar" alt="{{$reqItem->name}}">
                                    @endif
                                </td>

                                <td>{{$reqItem->offer}}%</td>
                                <td>({{\Carbon\Carbon::parse($reqItem->start_from)->format('d F, Y')}}) -
                                    ({{\Carbon\Carbon::parse($reqItem->end_at)->format('d F, Y')}})
                                </td>

                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                                data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                                            <li>
                                                <a href="#!" class="nav-link text-black"
                                                   onclick="forModal('{{ route('admin.campaign.edit', $reqItem->id) }}', '@translate(Approve Campaign Request)')">@translate(Approve)
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="#!" class="nav-link text-black"
                                                   onclick="confirm_modal('{{ route('admin.campaign.destroy', $reqItem->id) }}')">@translate(Delete)
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8"><h3 class="text-center">@translate(No Data Found)</h3></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
