<?php

namespace App\Http\Requests;

use App\Models\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterRequest extends FormRequest
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
            // 'name' => ['string', 'nullable', 'max:255'],
            // 'email' => ['string' , 'required', 'max:255', 'unique:users'],
            // 'password'  =>  ['string' , 'required' , 'min:8' , 'confirmed'],
        ];
    }
}
