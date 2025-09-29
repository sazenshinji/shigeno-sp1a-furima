<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        // FormRequest の validated() でデータを取得
        $user = app(CreateNewUser::class)->create($request->validated());

        Auth::login($user);

        return redirect()->route('profile.edit');
    }
}
