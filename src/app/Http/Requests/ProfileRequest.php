<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_image'    => 'image|mimes:jpeg,png',
            'username'      => 'required|string|max:20',
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
            'user_image.image' => '画像ファイルを選択してください',
            'user_image.mimes:png,jpeg' => '「.png」または「.jpeg」形式でアップロードしてください',
            'username.required' => 'お名前を入力してください',
            'username.max' => '20文字以内で入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '「3文字-4文字」で入力してください',
            'address.required' => '住所を入力してください',
            'address.max' => '40文字以内で入力してください',
            'building.max' => '20文字以内で入力してください',
        ];
    }
}
