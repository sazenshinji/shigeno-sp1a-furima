<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Charge;

class TransactionController extends Controller
{
    // 購入画面表示
    public function create(Product $product)
    {
        $profile = Auth::user()->profile ?? null; // プロフィール未登録も許容
        return view('transactions.purchase', compact('product', 'profile'));
    }

    // 購入処理
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'payment_method' => 'required|in:1,2',
        ], [
            'payment_method.required' => '支払い方法を選択してください。',
            'payment_method.in'       => '不正な支払い方法です。',
        ]);

        $tempProfile = session('temp_profile');
        $profile = Auth::user()->profile ?? null;

        $postal_code = $tempProfile['postal_code'] ?? ($profile->postal_code ?? null);
        $address     = $tempProfile['address'] ?? ($profile->address ?? null);
        $building    = $tempProfile['building'] ?? ($profile->building ?? null);

        if (!$postal_code || !$address) {
            return back()
                ->withErrors(['address' => '送付先を入力してください'])
                ->withInput();
        }

        // カード払いの場合は Stripe 決済
        if ($request->payment_method == 2) {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            Charge::create([
                'amount'      => $product->price, // 円単位 (整数)
                'currency'    => 'jpy',
                'description' => $product->name,
                'source'      => $request->stripeToken, // ★ ここが必須
            ]);
        }

        // トランザクション保存
        Transaction::create([
            'product_id'     => $product->id,
            'user_id'        => Auth::id(),
            'datetime'       => Carbon::now(),
            'payment_method' => $request->payment_method,
            'postal_code'    => $postal_code,
            'address'        => $address,
            'building'       => $building,
        ]);

        // 一時住所を削除
        session()->forget('temp_profile');

        return redirect()->route('products.index')
            ->with('success', '購入が完了しました！');
    }

}
