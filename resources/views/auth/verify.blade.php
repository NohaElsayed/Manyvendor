@extends('frontend.master')
@section('title') @translate(Verify) @endsection

@section('content')

    <div class="ps-my-account">
        <div class="container">
            <div class="ps-form--account ps-tab-root">
                <div class="card card-primary card-outline">
                    <div class="card-body" id="sign-in">
                        <div class="ps-form__content">
                            <div class="card-box-shared-body">
                                @if (isset($resent))
                                    <div class="alert alert-success" role="alert">
                                        {{$resent}}
                                    </div>
                                @endif

                                @translate(Before proceeding, please check your email for a verification link.)
                                @translate(If you did not receive the email)
                                <form class="d-inline" method="POST" action="{{ route('send.verify.token') }}">
                                    @csrf

                                    <input type="hidden" name="id" value="{{$id}}">

                                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">@translate(click here to request another)
                                    </button>

                                </form>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
