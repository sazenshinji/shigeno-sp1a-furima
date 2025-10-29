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

        //登録後にログイン
        Auth::login($user);

        // メール認証リンクを送信
        $user->sendEmailVerificationNotification();

        //メール送信後、確認案内ページへ
        return redirect()->route('verification.notice');
    }
}
