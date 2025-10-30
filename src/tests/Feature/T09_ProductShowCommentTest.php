<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class T09_ProductShowCommentTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_コメント送信機能()
    {
        // 対象商品 (product_id=1)
        $product = Product::find(1);

        // ----------------------------------------------------
        // ログアウト状態 → コメント送信禁止を確認
        // ----------------------------------------------------
        // ログアウト状態でコメント投稿を試みる
        $response = $this->post(route('products.comments.store', $product->id), [
            'comment' => 'ログアウト状態でのコメント',
        ]);

        // エラーメッセージを確認
        $response->assertRedirect(); // 未ログインならリダイレクトが起きる
        $response = $this->get(route('products.show', $product->id));
        $response->assertSeeText('コメント送信にはログインが必要です。');

        // DBに登録されていないことを確認
        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'comment' => 'ログアウト状態でのコメント',
        ]);

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

        // コメント件数が1件に（Seederでは0件＋今回の1件）
        $response->assertSeeText('1');          // アイコンの下の数字
        $response->assertSeeText('コメント(1)');
        $response->assertSeeText('PHPUnitテスト');
        $response->assertSeeText('山田 三郎');

        // コメントしたユーザー画像も表示されている
        $response->assertSee('storage/images/IMG20231112_R.jpg');
    }
}
