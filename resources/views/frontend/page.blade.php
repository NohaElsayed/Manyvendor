@extends('frontend.master')


@section('title') {{$page->title}} @stop

@section('content')
    {{-- content goes here --}}
    <div class="ps-page--single" id="contact-us">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{route('homepage')}}">@translate(Home)</a></li>
                    <li>{{$page->title}}</li>
                </ul>
            </div>
        </div>
        <div class="ps-contact-info">
            <div class="container">
                @foreach($page->content as $content)
                    <div class="ps-section__header">
                        <h3>{{$content->title}}</h3>
                    </div>
                    <div class="ps-section__content">
                        {{--here the content--}}
                        {!! $content->body !!}



                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop


