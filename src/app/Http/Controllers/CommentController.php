<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreCommentRequest;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Product $product)
    {
        Comment::create([
            'product_id' => $product->id,
            'user_id'    => Auth::id(),
            'comment'    => $request->comment,
            'datetime'       => Carbon::now(),
        ]);

        return redirect()->route('products.show', $product->id)
            ->with('success', 'コメントを投稿しました。');
    }
}