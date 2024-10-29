<?php

namespace App\Http\Requests\Admin\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function rules()
    {
        return [
            'payment_method' => 'required|string',
            'cash_received' => 'required_if:payment_method,cash|numeric|min:0',
        ];
    }
}