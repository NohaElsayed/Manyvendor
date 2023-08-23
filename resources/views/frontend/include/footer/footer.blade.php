<footer class="ps-footer ps-footer--3 t-pt-70 t-pb-70 p-xl-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
            <div class="ps-block--site-features ps-block--site-features-2 bg-white d-flex justify-content-center mt-5">
            @foreach(infopage('bottom',4) as $p)
                @if($p->page != null)
                    <div class="ps-block__item">
                        <a href="{{route('frontend.page',$p->page->slug)}}">
                            <div class="ps-block__left"><i class="{{$p->icon}}"></i></div>
                            <div class="ps-block__right">
                                <a href="{{route('frontend.page',$p->page->slug)}}">
                                    <h4>{{$p->header}}</h4>
                                    <p>{{$p->desc}}</p>
                                </a>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6 col-xl-3 mb-5 mb-xl-0 mt-5">
            <h4 class="s-footer text-uppercase mt-0">
                @translate(Contact Us)
            </h4>
            <p>
                @translate(Call us 24/7)
            </p>
            <ul class="info-list">
                <li class="info-list__item">
                    {{ getSystemSetting('type_address')  }}
                </li>
                <li class="info-list__item">
                <span class="info-list__icon">
                <i class="fa fa-phone-square"></i>
                </span>
                
                    Phone: {{getSystemSetting('type_number')}}
                </li>
            </ul>
            <ul class="social-list mt-4">
                @if(getSystemSetting('type_fb'))
                    <li class="social-list__item">
                        <a href="{{getSystemSetting('type_fb')}}" target="_blank" class="social-list__icon social-list__icon-fb">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                @endif
                @if(getSystemSetting('type_tw'))
                        <li class="social-list__item">
                            <a href="{{getSystemSetting('type_tw')}}" target="_blank" class="social-list__icon social-list__icon-tw">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                @endif
                @if(getSystemSetting('type_google'))
                        <li class="social-list__item">
                            <a href="{{getSystemSetting('type_google')}}" target="_blank" class="social-list__icon social-list__icon-pin">
                                <i class="fa fa-google"></i>
                            </a>
                        </li>
                @endif
            </ul>
        </div>

        @foreach(\App\Models\PageGroup::where('is_published',true)->with('pages')->get() as $pageGroups)
            @if($pageGroups->pages->count() >0)
                    <div class="col-md-4 col-xl-2 mb-5 mb-xl-0 mt-5">
                        <h4 class="s-footer text-uppercase mt-0">
                            {{$pageGroups->name}}
                        </h4>
                        <ul class="footer-list">

                            @foreach($pageGroups->pages as $page)
                                <li class="footer-list__item">
                                    <a href="{{route('frontend.page',$page->slug)}}" class="footer-list__link">
                                        {{$page->title}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
            @endif
        @endforeach
        </div>
        <div class="ps-footer__copyright mt-5 mb-0 border-0">
            @if(getSystemSetting('payment_logo') != null)
                <p><span>@translate(Your payments are secured)</span>
                    <img src="{{filePath(getSystemSetting('payment_logo'))}}" class="logo-payment-footer"></p>
            @endif
            @if(getSystemSetting('type_android')!== null || getSystemSetting('type_ios') !== null)
                <p class="mx-2">
                    @if(getSystemSetting('type_android')!== null)
                    <a href="{{getSystemSetting('type_android')}}" target="_blank">
                        <img src="{{ filePath(getSystemSetting('type_playstore'))}}" class="mobile-application"/>
                    </a>
                    @endif
                    @if(getSystemSetting('type_ios')!== null)
                    <a href="{{getSystemSetting('type_ios')}}" target="_blank">
                        <img src="{{ filePath(getSystemSetting('type_appstore'))}}" class="mobile-application"/>
                    </a>
                    @endif
                </p>
                @endif

                <p>© {{date('Y')}} {{getSystemSetting('type_footer')}}</p>

        </div>
    </div>
</footer>

<div id="back2top"><i class="pe-7s-angle-up"></i></div>


