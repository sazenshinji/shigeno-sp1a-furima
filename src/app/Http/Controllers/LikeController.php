<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Product $product)
    {
        $user = Auth::user();

        $like = $product->likes()->where('user_id', $user->id)->first();

        if ($like) {
            // 既にいいねしている → 解除
            $like->delete();
            $liked = false;
        } else {
            // まだ → いいね追加
            $product->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $product->likes()->count(),
        ]);
    }
}
