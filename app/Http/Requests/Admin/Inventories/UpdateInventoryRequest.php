<?php

namespace App\Http\Requests\Admin\Inventories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryRequest extends FormRequest
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
            'quantity' => 'required|integer|min:0', 
            'operation' => 'required|in:add,subtract', 
            'minimum_stock' => 'nullable|integer|min:0',
        ];
    }
}