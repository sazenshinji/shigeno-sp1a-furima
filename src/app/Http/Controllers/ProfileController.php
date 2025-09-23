<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Auth::user()->profile;
        return view('profile.edit', compact('profile'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();

        // 画像アップロード
        if ($request->hasFile('user_image')) {
            $path = $request->file('user_image')->store('profiles', 'public');
            $data['user_image'] = $path;
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->route('products.index')->with('success', 'プロフィールを更新しました');
    }
}
