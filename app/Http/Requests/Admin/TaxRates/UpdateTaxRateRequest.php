<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaxRateRequest extends FormRequest
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

    public function rules()
    {
        return [
            'type' => [
                'required',
                Rule::unique('tax_rates', 'type')->ignore($this->route('taxRate')->id), // Uniekheid controleren, huidig record uitsluiten
            ],
            'percentage' => 'required|numeric|min:0|max:100',
        ];
    }



}