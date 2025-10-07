<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // 商品一覧
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $tab = $request->input('tab', 'recommend');

        if ($tab === 'mylist' && Auth::check()) {
            $query = Auth::user()->likedProducts();
        } else {
            $query = Product::query();
        }

        if (Auth::check()) {
            $query->where('seller_id', '!=', Auth::id());
        }

        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $products = $query->with('transaction')->orderBy('created_at', 'desc')->get();

        return view('products.index', compact('products', 'keyword', 'tab'));
    }

    // 出品フォーム
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('products.create', compact('categories', 'conditions'));
    }

    // 出品処理
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer|min:1',
            'brand'       => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
            'condition_id' => 'required|exists:conditions,id',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories'  => 'required|array|min:1',
        ]);

        // 画像アップロード
        $path = $request->file('image')->store('products', 'public');

        // 商品登録
        $product = Product::create([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'brand'       => $validated['brand'] ?? '',
            'description' => $validated['description'],
            'image_path'  => $path,
            'condition_id' => $validated['condition_id'],
            'seller_id'   => Auth::id(),
        ]);

        // 中間テーブルにカテゴリーを保存
        $product->categories()->attach($validated['categories']);

        return redirect()->route('products.index')->with('success', '商品を出品しました！');
    }

    // 商品詳細
    public function show($id)
    {
        $product = Product::with([
            'likes',
            'comments.user.profile',
            'categories',
            'condition'
        ])->findOrFail($id);

        return view('products.show', compact('product'));
    }

}
