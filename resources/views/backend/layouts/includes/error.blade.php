<div class="container-fluid">
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible fade show  m-3" role="alert">
            <ul class="nav">
                @foreach ($errors->all() as $error)
                    <li class="mx-2">{{$error}}</li>
                @endforeach
            </ul>


            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>
