{{--campaign ajax url--}}
@if(vendorActive())
<input type="hidden" class="add-to-campaign-url" value="{{route('seller.campaign.products.store')}}">
<input type="hidden" class="remove-from-campaign-url" value="{{route('seller.campaign.products.destroy')}}">
    @else
    <input type="hidden" class="add-to-campaign-url" value="{{route('admin.campaign.products.store')}}">
    <input type="hidden" class="remove-from-campaign-url" value="{{route('admin.campaign.products.destroy')}}">
@endif
