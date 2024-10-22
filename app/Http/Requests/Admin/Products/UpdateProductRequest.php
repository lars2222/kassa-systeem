<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'barcode' => 'required|string|max:255', 
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|integer', 
            'tax_rate_id' => 'nullable|integer', 
            'btw_type' => 'required|string|in:high,low', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ];
    }



}