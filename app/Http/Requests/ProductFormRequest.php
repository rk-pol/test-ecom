<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{
    // protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return auth('web')->check();
        return true;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'short_description' => 'required|max:15',
            'long_description' => 'required|min:20',
            'brand_id' => 'required',
            'product_type_id' => 'required',
            'animal_id' => 'required',
            'price' => 'required|numeric',
            'articul' => 'required',
        ];
    }
}
