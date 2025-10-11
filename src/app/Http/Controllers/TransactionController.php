<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class TransactionController extends Controller
{
    // 🧾 購入画面
    public function create(Product $product)
    {
        $profile = Auth::user()->profile ?? null;

        return view('transactions.purchase', [
            'product' => $product,
            'profile' => $profile,
        ]);
    }

    // 💳 Stripe Checkoutにリダイレクト
    public function checkout(Request $request, Product $product)
    {
        $request->validate([
            'payment_method' => 'required|in:1,2',
        ], [
            'payment_method.required' => '支払い方法を選択してください。',
            'payment_method.in'       => '不正な支払い方法です。',
        ]);

        // 配送先チェック
        $tempProfile = session('temp_profile');
        $profile = Auth::user()->profile ?? null;

        $postal_code = $tempProfile['postal_code'] ?? ($profile->postal_code ?? null);
        $address     = $tempProfile['address'] ?? ($profile->address ?? null);
        $building    = $tempProfile['building'] ?? ($profile->building ?? null);

        if (!$postal_code || !$address) {
            return back()->withErrors(['address' => '送付先を入力してください'])->withInput();
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // ✅ 共通の支払いデータ
        $commonLineItem = [[
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => ['name' => $product->name],
                'unit_amount' => (int)$product->price,
            ],
            'quantity' => 1,
        ]];

        // ✅ Stripe Checkoutセッション作成（カード or コンビニ）
        if ($request->payment_method == 2) {
            $paymentType = ['card'];
        } elseif ($request->payment_method == 1) {
            $paymentType = ['konbini'];
        }

        $session = StripeSession::create([
            'payment_method_types' => $paymentType,
            'line_items' => $commonLineItem,
            'mode' => 'payment',
            'success_url' => route('products.purchase.complete', ['product' => $product->id])
                . '?session_id={CHECKOUT_SESSION_ID}&method=' . $request->payment_method,
            'cancel_url' => route('products.purchase', ['product' => $product->id]),
        ]);

        return redirect($session->url);
    }

    // ✅ Stripe決済完了後（カード・コンビニ共通）
    public function complete(Request $request, Product $product)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->query('session_id');
        $method = $request->query('method'); // 1:コンビニ, 2:カード

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
        } catch (\Exception $e) {
            return redirect()->route('products.purchase', ['product' => $product->id])
                ->withErrors(['payment' => '決済確認に失敗しました。']);
        }

        if ($session->payment_status === 'paid') {
            $tempProfile = session('temp_profile');
            $profile = Auth::user()->profile ?? null;

            $postal_code = $tempProfile['postal_code'] ?? ($profile->postal_code ?? '');
            $address     = $tempProfile['address'] ?? ($profile->address ?? '');
            $building    = $tempProfile['building'] ?? ($profile->building ?? '');

            // ✅ DB登録
            Transaction::create([
                'product_id'     => $product->id,
                'user_id'        => Auth::id(),
                'datetime'       => Carbon::now(),
                'payment_method' => $method,
                'postal_code'    => $postal_code,
                'address'        => $address,
                'building'       => $building,
            ]);

            session()->forget('temp_profile');

            if ($method == 1) {
                $msg = 'コンビニ支払いが完了しました！';
            } else {
                $msg = 'カード決済が完了しました！';
            }

            return redirect()->route('products.index')->with('success', $msg);
        }

        return redirect()->route('products.purchase', ['product' => $product->id])
            ->withErrors(['payment' => '決済が完了しませんでした。']);
    }
}
