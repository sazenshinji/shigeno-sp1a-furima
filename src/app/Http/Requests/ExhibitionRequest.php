<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image'         => 'required|image|mimes:jpeg,png',
            'name'          => 'required',
            'description'   => 'required|string|max:255',
            'categories'    => 'required',
            'condition_id'  => 'required',
            'price'         => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => '画像ファイルを選択してください',
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'name.required' => '商品名を入力してください',
            'description.required'  => '商品説明を入力してください',
            'description.max'       => '255文字以内で入力してください',
            'categories.required' => 'カテゴリーを選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'price.required'    => '価格を入力してください',
            'price.numeric'     => '数字で入力してください',
            'price.min'         => '０円以上で入力してください',
        ];
    }
}
