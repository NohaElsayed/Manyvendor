<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name'          => 'required|max:255',
          'email'         => 'required|unique:vendors|unique:users',
          'phone'         => 'required|numeric',
          'shop_name'     => 'required|unique:vendors|max:255',
          'trade_licence' => 'required|max:255',
          'shop_logo'     => 'required',
        ];
    }

    /**
      * Custom message for validation
      *
      * @return array
      */
       public function messages()
       {
           return [
               'name.required'          => translate('Name is required!'),
               'email.required'         => translate('Email is required!'),
               'email.unique'           => translate('Email already exist!'),
               'phone.required'         => translate('Phone number is required!'),
               'phone.numeric'          => translate('Phone number must be numeric'),
               'shop_name.required'     => translate('Shop name is required!'),
               'shop_name.unique'       => translate('Shop name already exist!'),
               'trade_licence.required' => translate('Shop trade licence is required!'),
               'trade_licence.unique'   => translate('Shop trade licence already exist!'),
               'shop_logo.required'     => translate('Shop logo is required!'),
           ];
       }

}