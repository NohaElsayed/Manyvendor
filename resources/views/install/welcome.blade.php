@extends('install.app')
@section('content')
    <div class="m-5">
<div class="text-center">
    <img src="{{asset('logo.png')}}" class="bg-primary p-2 mb-4 rounded-sm" width="300px" height="100px">
    <h5>You will need to know the following items before proceeding</h5>
</div>
<div class="m-5">
    <ul class="list-group">
        <li class="list-group-item">
            <h6 class="font-weight-normal">
                <i class="fa  fa-check"></i> Database Host Name</h6>
        </li>
        <li class="list-group-item">
            <h6 class="font-weight-normal">
                <i class="fa fa-check"></i> Database Name</h6>
        </li>
        <li class="list-group-item">
            <h6 class="font-weight-normal">
                <i class="fa fa-check"></i> Database User Name</h6>
        </li>
        <li class="list-group-item">
            <h6 class="font-weight-normal">
                <i class="fa fa-check"></i> Database Password</h6>
        </li>
    </ul>
</div>

<div class="m-2">
    <p>During the installation process. we will check if the files there needed to be written (<strong>.env file</strong>) have <strong>write permission</strong>.
        We Will also check if <strong>curl</strong> are enabled on your server or not.</p>
    <br>
    <p>Gather the information mentioned above before hitting the start installation button. if you are ready...</p>

    <div class="center">
        <a href="{{route('permission')}}" class="btn btn-block btn-primary"> Start Installation Process</a>
    </div>
</div>
    </div>


@endsection
