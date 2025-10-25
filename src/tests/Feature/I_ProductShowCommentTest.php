<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;

class I_ProductShowCommentTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;


    public function test_コメント機能の表示とバリデーション()
    {
        // 対象商品 (product_id=4)
        $product = Product::find(4);

        // ----------------------------------------------------
        // ログアウト状態 → コメント入力欄が非表示
        // ----------------------------------------------------
        $response = $this->get(route('products.show', $product->id));
        $response->assertStatus(200);

        // 「商品へのコメント」欄がないことを確認
        $response->assertDontSee('商品へのコメント');
        $response->assertDontSee('コメントを送信する');

        // ----------------------------------------------------
        // ログイン状態でコメント未入力 → バリデーション
        // ----------------------------------------------------
        $user = User::find(3);
        $this->actingAs($user);

        // 空コメントで送信
        $response = $this->post(route('products.comments.store', $product->id), [
            'comment' => '',
        ]);

        // バリデーションエラーを確認
        $response->assertSessionHasErrors([
            'comment' => 'コメントを入力してください',
        ]);

        // ----------------------------------------------------
        // 256文字のコメント → 255文字制限バリデーション
        // ----------------------------------------------------
        $longComment = str_repeat('あ', 256);
        $response = $this->post(route('products.comments.store', $product->id), [
            'comment' => $longComment,
        ]);

        $response->assertSessionHasErrors([
            'comment' => 'コメントは255文字以内で入力してください',
        ]);

        // ----------------------------------------------------
        // 正常コメント投稿 → 表示確認
        // ----------------------------------------------------
        $response = $this->post(route('products.comments.store', $product->id), [
            'comment' => 'PHPUnitテスト',
        ]);

        // DB登録確認
        $this->assertDatabaseHas('comments', [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'comment' => 'PHPUnitテスト',
        ]);

        // 再表示して内容確認
        $response = $this->get(route('products.show', $product->id));
        $response->assertStatus(200);

        // コメント件数が3件に（Seederの2件＋今回の1件）
        $response->assertSeeText('コメント(3)');
        $response->assertSeeText('PHPUnitテスト');
        $response->assertSeeText('山田 三郎');

        // コメントしたユーザー画像も表示されている
        $response->assertSee('storage/images/IMG20231112_R.jpg');
    }
}
