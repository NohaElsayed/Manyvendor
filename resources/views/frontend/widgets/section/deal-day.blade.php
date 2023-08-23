@php
    $all_campaigns = App\Models\Campaign::where('active_for_customer',1)->where('end_at','>=',Carbon\Carbon::now()->format('Y-m-d'))->orderBy('start_from','asc')->get();
    $campaigns_count = App\Models\Campaign::where('active_for_customer',1)->where('end_at','>',Carbon\Carbon::now()->format('Y-m-d'))->count();
    $campaigns = collect();
    foreach ($all_campaigns as $single_campaign) {
        $demo_obj = new App\Models\Demo;
        $demo_obj->slug = $single_campaign->slug;
        $demo_obj->title = $single_campaign->title;
        $demo_obj->banner = filePath($single_campaign->banner);
        $demo_obj->end_at = $single_campaign->end_at;
        $campaigns->push($demo_obj);
    }
@endphp
@if ( $campaigns_count > 0 )
    <div class="ps-deal-of-day">
        <div class="container">
            <div class="ps-section__header">
                <div class="ps-block--countdown-deal">
                    <div class="ps-block__left">
                        <h3>@translate(Live Campaigns)</h3>
                    </div>

                </div>
                <a href="{{ route('customer.campaigns.index') }}">@translate(View all)</a>
            </div>
            <div class="ps-section__content">
                <div class="row">

                    @forelse($campaigns as $campaign)
                    @if ($campaign->end_at > Carbon\Carbon::now())
                            <div class="col-md-6 col-xl-3 mb-5">
                                <a href="{{route('customer.campaign.products', $campaign->slug)}}"
                                   title="{{$campaign->title}}">
                                    <div class="card card-body bd-light rounded-sm">
                                        <img src="{{$campaign->banner}}" class="img-fluid rounded-sm campaign-img"
                                             alt="{{$campaign->title}}"/>
                                        @if ($campaign->end_at > Carbon\Carbon::now())
                                            <span class="bg-danger p-2 text-white rounded-pill live-now">@translate(Live now)</span>
                                        @else
                                            <span class="bg-danger p-2 text-white rounded-pill live-now">@translate(Time Out)</span>
                                        @endif
                                    </div>
                                </a>

                                @if ($campaign->end_at > Carbon\Carbon::now())
                                    <div class="ps-block--countdown-deal mt-2 mb-2">
                                        <figure class="m-auto">
                                            <figcaption>@translate(End in):</figcaption>
                                            <ul class="ps-countdown"
                                                data-time="{{ $campaign->end_at->format('F d, Y H:i:s') }}">
                                                <li><span class="days"></span></li>
                                                <li><span class="hours"></span></li>
                                                <li><span class="minutes"></span></li>
                                                <li><span class="seconds"></span></li>
                                            </ul>
                                        </figure>
                                    </div>
                                @endif

                            </div>
                            @endif
                        @empty
                            <div class="col-md-12 text-center text-danger fs-18 py-5 card card-body">
                                @translate(There is no campaign live now.)
                            </div>
                        @endforelse
                </div>
            </div>
        </div>
    </div>
@endif
