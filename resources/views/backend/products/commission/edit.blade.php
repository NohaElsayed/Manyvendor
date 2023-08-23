<form action="{{route('commissions.update')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$commission->id}}">
    <div class="form-group">
        <label class="col-form-label">@translate(Amount)</label>
        <input required type="number" value="{{$commission->amount}}" class="form-control" step="0.01" min="0" placeholder="@translate(Enter the number)" name="amount">
    </div>
    <div class="form-group">
        <label class="col-form-label">@translate(Select type)</label>
        <select required class="form-control select2" name="type">
            <option value="">@translate(Select type)</option>
            @if(commissionStatus())
            <option value="percentage" {{$commission->type == 'percentage' ? 'selected':null}}>(%)@translate(Percentage)</option>
            @else
            <option value="flat" {{$commission->type == 'flat' ? 'selected':null}}>@translate(Flat amount)</option>
            @endif
        </select>
    </div>

    @if(!commissionStatus())
        <div class="form-group">
            <label>@translate(Input the amount start to end for category commission)</label>
            <div class="row">
                <div class="col">
                    <input type="number" step="0.01" min="0" name="start_amount" class="form-control" value="{{$commission->start_amount}}">
                </div>
                <div class="col">
                    <input type="number" step="0.01" min="0" class="form-control" name="end_amount" value="{{$commission->end_amount}}">
                </div>
            </div>
        </div>
    @endif
    <button class="btn btn-primary" type="submit">@translate(Save)</button>
</form>
