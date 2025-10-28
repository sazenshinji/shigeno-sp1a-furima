<?php

namespace App\Http\Controllers;


use App\Http\Requests\CommentRequest;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Product $product)
    {
        //ログインしていない場合はエラーを返してリダイレクト
        if (!Auth::check()) {
            return redirect()
                ->route('products.show', $product->id)
                ->with('login_required_comment', 'コメント送信にはログインが必要です。');
        }

        //ログイン済みならコメントを保存
        Comment::create([
            'product_id' => $product->id,
            'user_id'    => Auth::id(),
            'comment'    => $request->comment,
            'datetime'   => Carbon::now(),
        ]);

        return redirect()->route('products.show', $product->id)
            ->with('success', 'コメントを投稿しました。');
    }
}
