<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Like;

class ProductShowLikeTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_いいね機能()
    {
        // 🔹 ログインユーザー (user_id=3)
        $user = \App\Models\User::find(3);
        $this->actingAs($user);

        // 🔹 対象商品 (product_id=4)
        $product = \App\Models\Product::find(4);

        // ----------------------------------------------------
        // ① 初期状態：いいねなし
        // ----------------------------------------------------
        $response = $this->get(route('products.show', $product->id));
        $response->assertStatus(200);

        // DB上も「いいねなし」
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // 表示確認：アイコン＝21_star.png、いいね数＝0
        $response->assertSee('storage/images/21_star.png');
        $response->assertSeeText('0');

        // ----------------------------------------------------
        // ② 1回目クリック → 「いいね」追加
        // ----------------------------------------------------
        $this->post(route('products.like', ['product' => $product->id]));

        // DBに登録されていることを確認
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // 再取得して件数確認
        $response = $this->get(route('products.show', $product->id));
        $response->assertSee('storage/images/21_star_red.png');
        $response-> assertSeeText('1');

        // ----------------------------------------------------
        // ③ 2回目クリック → 「いいね」削除
        // ----------------------------------------------------
        $this->post(route('products.like', ['product' => $product->id]));

        // DBから削除されていることを確認
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // 再取得して件数確認
        $response = $this->get(route('products.show', $product->id));
        $response->assertSee('storage/images/21_star.png');
        $response->assertSeeText('0');
    }
}