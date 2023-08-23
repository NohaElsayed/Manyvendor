<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class EcommerceOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $bill = Customer::where('user_id',$this->user_id)->first();
        return [
            'id' => $this->id,
            'user_id' =>$this->user_id,
            'name' => $this->name,
            'orderNumber' => $this->order_number,
            'email' => $this->email,
            'toPhone' => $this->phone,
            'toAddress' => $this->address,
            'toDivisionName' => $this->division->district_name ?? '',
            'toAreaName' => $this->area->thana_name ?? '',
            'note' => $this->note ?? '',
            'toLogisticName' => $this->logistic->name  ?? '',
            'formPhone' => $bill->phn_no  ?? '',
            'formAddress' => $bill->address  ?? '',
            'logisticCharge' => formatPrice($this->logistic_charge)   ?? '',
            'orderNumber' => $this->order_number  ?? '',
            'appliedCoupon' => $this->applied_coupon  ?? '',
            'payAmount' => formatPrice($this->pay_amount)   ?? '',
            'paymentType' => $this->payment_type == "cod" ? 'Cash On Delivery' : $this->payment_type ?? '',
            'orderDate' => date('d-M-y',strtotime($this->created_at))  ?? '',
            'orderProduct' => EcommerceOrderProduct::collection($this->order_product),
        ];
    }
}


class EcommerceOrderProduct extends JsonResource{
    public function toArray($request)
    {
        return [
            'bookingCode' => (string)$this->booking_code  ?? '',
            'orderNumber' => (string)$this->order_number  ?? '',
            'shop' => env('APP_NAME'),
            'productName' => $this->product->name . Str::upper($this->product_stock->product_variants) ?? '',
            'productImage' => filePath($this->product->image)  ?? '',
            'productPrice' => formatPrice($this->product_price)  ?? '',
            'quantity' => $this->quantity  ?? '',
            'status' => $this->status  ?? '',
        ];
    }
}