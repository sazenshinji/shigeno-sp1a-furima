<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // 商品一覧
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $tab = $request->input('tab', 'recommend'); // デフォルトは「おすすめ」

        if ($tab === 'mylist' && Auth::check()) {
            // ログイン中ユーザーのマイリスト
            $query = Auth::user()->likedProducts();
        } else {
            // おすすめ（全商品）
            $query = Product::query();
        }

        // 🔹 自分が出品した商品を除外する
        if (Auth::check()) {
            $query->where('seller_id', '!=', Auth::id());
        }

        // 🔹 検索条件がある場合
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $products = $query->with('transaction')->orderBy('created_at', 'desc')->get();

        return view('products.index', compact('products', 'keyword', 'tab'));
    }

    // 出品フォーム
    public function create()
    {
        return view('products.create');
    }

    // 出品処理
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'required|image|max:2048',
        ]);

        // 画像アップロード
        $path = $request->file('image')->store('products', 'public');

        Product::create([
            'name'       => $request->name,
            'image_path' => $path,
        ]);

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    // 商品詳細表示
    public function show($id)
    {
        $product = Product::with(['likes', 'comments', 'categories', 'condition'])
            ->findOrFail($id);

        return view('products.show', compact('product'));
    }

}
