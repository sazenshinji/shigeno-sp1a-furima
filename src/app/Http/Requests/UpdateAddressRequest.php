<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'postal_code' => ['required', 'min:7', 'max:8'],
            'address'     => ['required', 'max:40'],
        ];
    }
    public function messages()
    {
        return [
            'postal_code.required' => '郵便番号は必須です。',
            'postal_code.min'      => '郵便番号は7文字以上で入力してください。',
            'postal_code.max'      => '郵便番号は8文字以下で入力してください。',
            'address.required'     => '住所は必須です。',
            'address.max'          => '住所は40文字以下で入力してください。',
        ];
    }
}
