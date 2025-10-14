<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileTempRequest extends FormRequest
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
            'postal_code' => [
                'required',
                'regex:/^\d{3}-\d{4}$/'
            ],
            'address'       => 'required|string|max:40',
            'building'      => 'nullable|string|max:20',
        ];
    }
    public function messages(): array
    {
        return [
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '「3文字-4文字」で入力してください',
            'address.required' => '住所を入力してください',
            'address.max' => '40文字以内で入力してください',
            'building.max' => '20文字以内で入力してください',
        ];
    }
}
