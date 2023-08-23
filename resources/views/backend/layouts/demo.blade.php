@extends('backend.layouts.master')
@section('title') Group Details @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"> Group</h3>

            <div class="float-right">
                <a class="btn btn-success" href="{{ route("groups.index") }}">
                    Group List
                </a>
            </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body p-2">


            {{--                                {{ ($loop->index+1) + ($courses->currentPage() - 1)*$courses->perPage() }}--}}
            <h2>The body here</h2>


        </div>

    </div>


@endsection

