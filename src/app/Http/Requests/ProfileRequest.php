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
            'username'    => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'address'     => 'nullable|string|max:255',
            'building'    => 'nullable|string|max:255',
            'user_image'  => 'nullable|image|max:2048',
        ];
    }
}
