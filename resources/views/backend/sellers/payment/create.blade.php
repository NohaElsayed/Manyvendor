<div class="card-body">
    <h3><b>@translate(Your Current Balance is) : {{formatPrice($vendor->balance)}}</b></h3>
    <form action="{{route('payments.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="status" value="Request">
        <div class="form-group">
            <label>@translate(Withdrawal Amount) <span class="text-danger">*</span></label>
            <input class="form-control" type="number" min="10" max="{{$vendor->balance}}" name="amount" required>
        </div>
        <div class="form-group">
            <label>@translate(Payment Process) <span class="text-danger">*</span></label>
            <select class="form-control lang select2" name="process" required>

                @if (isset($check_account->account_number) || isset($check_account->paypal_acc_name) || isset($check_account->stripe_card_number))
                    <option value="">@translate(Select The Payment Method)</option>
                @else
                    <option value="">@translate(Setup Your Account First)</option>
                @endif

                @if (isset($check_account->account_number))
                    <option value="Bank">@translate(Bank)</option>
                @endif
                
                @if (isset($check_account->paypal_acc_name))
                    <option value="Paypal">@translate(Pay Pal)</option>
                @endif
                
                @if (isset($check_account->stripe_card_number))
                    <option value="Stripe">@translate(Stripe)</option>
                @endif

            </select>
        </div>
        <div class="form-group">
            <label>@translate(Description)</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Save)</button>
        </div>

    </form>
</div>
