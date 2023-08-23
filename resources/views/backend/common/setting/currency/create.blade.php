<form action="{{route('currencies.store')}}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="name" class="col-form-label text-md-right">@translate(Name) <span class="text-danger">*</span></label>
        <input placeholder="Ex : United State" type="text" class="form-control" name="name" autofocus required>
    </div>

    <div class="form-group">
        <label for="name" class="col-form-label text-md-right">@translate(Symbol) <span class="text-danger">*</span></label>
        <input placeholder="Ex : $" type="text" class="form-control" name="symbol" required>
    </div>

    <div class="form-group">
        <label for="name" class="col-form-label text-md-right">@translate(Code) <span class="text-danger">*</span></label>
        <input placeholder="Ex : USD" type="text" class="form-control" name="code" required>
    </div>

    <div class="form-group">
        <label for="name" class="col-form-label text-md-right">@translate(Exchange Rate Ex: 1 USD = ? ) <span class="text-danger">*</span></label>
        <input  min="0.01" step="0.01" placeholder="Ex: 1 USD = ?" type="number" class="form-control" name="rate" required>
    </div>

    <div class="form-group">
        <label class="control-label">@translate(Select country Flag) <span
                class="text-danger">*</span></label>
        <div class="">
            <select class="form-control lang" name="image" required>
                <option value=""></option>
                @foreach(readFlag() as $item)
                    @if ($loop->index >1)
                        <option value="{{$item}}"
                                data-image="{{asset('images/lang/'.$item)}}"> {{flagRenameAuto($item)}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="float-right">
        <button class="btn btn-primary" type="submit">@translate(Save)</button>
    </div>


</form>
