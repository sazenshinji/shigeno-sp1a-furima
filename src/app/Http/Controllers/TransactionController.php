<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class TransactionController extends Controller
{
    // 購入画面表示
    public function create(Product $product)
    {
        $profile = Auth::user()->profile ?? null;

        // Stripeのシークレットキー設定
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // PaymentIntentを作成（カード決済の準備）
        $intent = PaymentIntent::create([
            'amount' => (int)$product->price, // JPYは整数
            'currency' => 'jpy',
            'payment_method_types' => ['card'],
        ]);

        return view('transactions.purchase', [
            'product'      => $product,
            'profile'      => $profile,
            'clientSecret' => $intent->client_secret, // フロントに渡す
        ]);
    }

    // 購入処理（決済後に呼ばれる）
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

        // ✅ 配送先が未入力なら決済処理に入らない
        if (!$postal_code || !$address) {
            return back()
                ->withErrors(['address' => '送付先を入力してください'])
                ->withInput();
        }

        // Stripe秘密鍵をセット（両方の処理で必要）
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // --- 支払い処理 ---
        if ($request->payment_method == 1) {
            // ✅ コンビニ払い
            $paymentIntent = PaymentIntent::create([
                'amount' => (int)$product->price,
                'currency' => 'jpy',
                'payment_method_types' => ['konbini'],
            ]);

            // DB保存
            Transaction::create([
                'product_id'     => $product->id,
                'user_id'        => Auth::id(),
                'datetime'       => Carbon::now(),
                'payment_method' => $request->payment_method,
                'postal_code'    => $postal_code,
                'address'        => $address,
                'building'       => $building,
            ]);

            session()->forget('temp_profile');

            // コンビニ払い用の画面に遷移
            return view('transactions.konbini', [
                'paymentIntent' => $paymentIntent,
                'product'       => $product,
            ]);
        }

        if ($request->payment_method == 2) {
            // ✅ カード払い
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($paymentIntent->status === 'succeeded') {
                Transaction::create([
                    'product_id'     => $product->id,
                    'user_id'        => Auth::id(),
                    'datetime'       => Carbon::now(),
                    'payment_method' => $request->payment_method,
                    'postal_code'    => $postal_code,
                    'address'        => $address,
                    'building'       => $building,
                ]);

                session()->forget('temp_profile');

                return redirect()->route('products.index')
                    ->with('success', 'カード決済が完了しました！');
            } else {
                return back()->withErrors(['payment' => 'カード決済に失敗しました。']);
            }
        }
    }
}
