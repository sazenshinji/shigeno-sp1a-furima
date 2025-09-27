<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 商品一覧
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::search($keyword)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('products.index', compact('products', 'keyword'));
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
}
