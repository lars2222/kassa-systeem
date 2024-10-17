<?php

namespace App\Http\Requests\Admin\TaxRates;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaxRateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
                Rule::unique('tax_rates', 'type'), 
            ],
            'percentage' => 'required|numeric|min:0|max:100',
        ];
    }
}