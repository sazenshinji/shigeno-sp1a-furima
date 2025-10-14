<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ProfileTempRequest;
use App\Models\Profile;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{

    public function edit(Request $request)
    {
        $profile = Auth::user()->profile;
        $from = $request->query('from', 'index'); // デフォルトは index に戻る
        return view('profiles.edit', compact('profile', 'from'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        $profile = $user->profile; // 現在のプロフィールを取得

        if ($request->hasFile('user_image')) {
            // ✅ 新しく画像をアップロードした場合
            $path = $request->file('user_image')->store('profiles', 'public');
            $data['user_image'] = $path;
        } elseif (!$profile || is_null($profile->user_image)) {
            // ✅ 画像未選択 ＆ DBに画像が登録されていない場合 → デフォルト画像を設定
            $data['user_image'] = 'images/23_default-user.png';
        } else {
            // ✅ 画像未選択 ＆ DBに既に画像がある場合 → 何も変更しない
            unset($data['user_image']);
        }

        // updateOrCreate：既存なら更新、なければ新規作成
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        // 呼び出し元によってリダイレクト先を変える
        if ($request->input('from') === 'profile') {
            return redirect()->route('profile.show')->with('success', 'プロフィールを更新しました');
        }

        return redirect('http://localhost/?tab=mylist')->with('success', 'プロフィールを更新しました');
    }


    // 一時住所変更フォーム表示
    public function editTemp(Request $request)
    {
        $productId = $request->query('product_id');

        // セッションから一時住所情報を取得（未設定なら空配列）
        $tempProfile = session('temp_profile', [
            'postal_code' => '',
            'address'    => '',
            'building'   => '',
        ]);

        return view('profiles.edit_temp', [
            'tempProfile' => $tempProfile,
            'productId'   => $productId,
        ]);
    }

    // 一時住所更新処理
    public function updateTemp(ProfileTempRequest $request)
    {
        $validated = $request->validate([
            'postal_code' => 'required|min:7|max:8',
            'address'     => 'required|max:40',
            'building'    => 'nullable|max:40',
        ]);

        // セッションに保存
        session(['temp_profile' => $validated]);

        // 購入画面に戻る
        return redirect()->route('products.purchase', ['product' => $request->product_id]);
    }

    public function  profile()
    {
        $user = Auth::user();
        $profile = $user->profile; // ★ プロフィールを取得

        // 出品した商品
        $myProducts = Product::where('seller_id', $user->id)->get();

        // 購入した商品
        $purchasedProducts = Product::whereIn('id', function ($query) use ($user) {
            $query->select('product_id')
                ->from('transactions')
                ->where('user_id', $user->id);
        })->get();

        // ★ $profile もビューに渡す
        return view('profiles.profile', compact('user', 'profile', 'myProducts', 'purchasedProducts'));
    }
}
