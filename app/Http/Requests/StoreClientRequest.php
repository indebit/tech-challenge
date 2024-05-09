<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'name' => 'required|string|max:190',
            'email' => 'nullable|required_if:phone,null|email:rfc,dns',
            'phone' => 'nullable|required_if:email,null|regex:/^\+?\d[\d\s]*$/', // regex to allow only numbers, spaces and '+' sign
        ];
    }
}
