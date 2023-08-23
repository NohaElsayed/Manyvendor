
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-5">
                <h1 class="m-0 text-dark">@yield('title')</h1>
            </div>
            <div class="col-md-4 d-none">
                <ol class="breadcrumb float-sm-right">
                    @foreach($segments = request()->segments() as $index=>$segment)
                    <li class="breadcrumb-item">
                        <a href="{{url(implode('/',array_slice($segments,0,($index+1))))}}">
                            {{Str::title($segment)}}</a>
                    </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>


