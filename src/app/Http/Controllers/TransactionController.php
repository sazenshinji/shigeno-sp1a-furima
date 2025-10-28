<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class TransactionController extends Controller
{
    // 購入画面
    public function create(Product $product)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('products.show', $product->id)
                ->with('login_required_purchase', '購入するにはログインが必要です');
        }

        $profile = Auth::user()->profile ?? null;

        // セッションに保存されている支払い方法（直前の選択を保持）
        $selectedMethod = session('selected_payment_method', null);

        return view('transactions.purchase', [
            'product' => $product,
            'profile' => $profile,
            'selectedMethod' => $selectedMethod,
        ]);
    }

    // 支払い方法選択時に呼ばれる
    public function selectPaymentMethod(Request $request, Product $product)
    {
        $method = $request->input('payment_method');

        // セッションに保存
        session(['selected_payment_method' => $method]);

        // 同じ購入画面へリダイレクト
        return redirect()->route('products.purchase', ['product' => $product->id]);
    }

    // Stripe Checkoutにリダイレクト
    public function checkout(PurchaseRequest $request, Product $product)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $commonLineItem = [[
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => ['name' => $product->name],
                'unit_amount' => (int)$product->price,
            ],
            'quantity' => 1,
        ]];

        $postal_code = $request->input('postal_code');
        $address     = $request->input('address');
        // 🔽 空欄なら null に変換
        $building    = $request->filled('building') && $request->input('building') !== ''
            ? $request->input('building')
            : null;

        // 支払い方法ごとの設定
        if ($request->payment_method == 1) {
            // ✅ コンビニ払い（テスト用：即DB登録）
            $paymentType = ['konbini'];
            $method = 1;

            Transaction::create([
                'product_id'     => $product->id,
                'user_id'        => Auth::id(),
                'datetime'       => Carbon::now(),
                'payment_method' => 1,
                'postal_code'    => $postal_code,
                'address'        => $address,
                'building'       => $building, // ← 空欄時はNULL
            ]);
        } elseif ($request->payment_method == 2) {
            // ✅ カード払い（決済完了後に登録する）
            $paymentType = ['card'];
            $method = 2;
        } else {
            return back()->withErrors(['payment_method' => '支払い方法を選択してください']);
        }

        // ✅ Stripeセッション作成（カード・コンビニ共通）
        $session = StripeSession::create([
            'payment_method_types' => $paymentType,
            'line_items' => $commonLineItem,
            'mode' => 'payment',
            'success_url' => route('products.purchase.complete', ['product' => $product->id])
                . '?session_id={CHECKOUT_SESSION_ID}&method=' . $method,
            'cancel_url' => route('products.purchase', ['product' => $product->id]),
        ]);

        return response()->json(['url' => $session->url]);
    }

    // Stripe決済完了後（カード・コンビニ共通）
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

            // ---- ✅ 建物名の扱いを厳密に変更 ----
            if (is_array($tempProfile)) {
                // temp_profileがある場合は優先
                $postal_code = $tempProfile['postal_code'] ?? ($profile->postal_code ?? '');
                $address     = $tempProfile['address'] ?? ($profile->address ?? '');
                // buildingキーが存在しているか確認し、空欄ならNULLに変換
                if (array_key_exists('building', $tempProfile)) {
                    $building = $tempProfile['building'] === '' ? null : $tempProfile['building'];
                } else {
                    // キーがなければプロフィール参照
                    $building = $profile->building ?? null;
                }
            } else {
                // temp_profileが存在しない場合はプロフィールを使用
                $postal_code = $profile->postal_code ?? '';
                $address     = $profile->address ?? '';
                $building    = $profile->building ?? null;
            }

            // ---- ✅ DB登録 ----
            Transaction::create([
                'product_id'     => $product->id,
                'user_id'        => Auth::id(),
                'datetime'       => Carbon::now(),
                'payment_method' => $method,
                'postal_code'    => $postal_code,
                'address'        => $address,
                'building'       => $building, // ← 空欄時は確実にNULL
            ]);

            session()->forget('temp_profile');

            $msg = $method == 1
                ? 'コンビニ支払いが完了しました！'
                : 'カード決済が完了しました！';

            return redirect()->route('products.index')->with('success', $msg);
        }

        return redirect()->route('products.purchase', ['product' => $product->id])
            ->withErrors(['payment' => '決済が完了しませんでした。']);
    }

}