<?php

namespace App\Http\Requests\Admin\Discounts;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'start_date' => 'required|date', 
            'end_date' => 'nullable|date|after_or_equal:start_date', 
        ];
    }
}