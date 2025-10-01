<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    // 購入画面表示
    public function create(Product $product)
    {
        $profile = Auth::user()->profile; // ログイン中ユーザーのプロフィール

        return view('transactions.purchase', compact('product', 'profile'));
    }

    // 購入処理
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'payment_method' => 'required|in:1,2',
        ]);

        Transaction::create([
            'product_id'     => $product->id,
            'user_id'        => Auth::id(),
            'date'           => Carbon::now(),
            'payment_method' => $request->payment_method,
            'postal_code'    => $request->postal_code ?? Auth::user()->profile->postal_code,
            'address'        => $request->address ?? Auth::user()->profile->address,
            'building'       => $request->building ?? Auth::user()->profile->building,
        ]);

        return redirect()->route('products.index')->with('success', '購入が完了しました！');
    }
}
