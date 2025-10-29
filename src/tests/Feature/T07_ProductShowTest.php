<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T07_ProductShowTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_商品詳細情報取得()
    {
        // 対象の商品（革靴 = product_id=4）詳細ページにアクセス
        $response = $this->get(route('products.show', 4));

        // ステータス200（正常表示）
        $response->assertStatus(200);

        // ==============================
        // 商品情報の基本表示確認
        // ==============================
        $response->assertSee('革靴');
        $response->assertSee('X靴製作所');
        $response->assertSee('4,000');
        $response->assertSee('(税込)');
        $response->assertSee('storage/images/04_革靴.jpg');
        $response->assertSee('クラシックなデザインの革靴');
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
        $response->assertSee('状態が悪い');
        $response->assertSee('商品説明');
        $response->assertSee('商品の情報');

        // ==============================
        // いいね・コメント関連の表示確認
        // ==============================

        // いいねアイコン（未ログイン時も表示される）
        $response->assertSee('storage/images/21_star.png');

        // コメントアイコン
        $response->assertSee('storage/images/22_comment.png');

        // いいね数・コメント数表示
        $response->assertSee('0');                // いいね0件
        $response->assertSee('2');                // コメント2件
        $response->assertSee('コメント(2)');      // "コメント(2)"

        // コメント投稿セクション
        $response->assertSee('商品へのコメント');
        $response->assertSee('コメントを送信する');

        // コメント入力用テキストエリア（リストボックス）
        $response->assertSee('<textarea', false);
        $response->assertSee('name="comment"', false);

        // ==============================
        // コメント表示の確認
        // ==============================
        $response->assertSee('山田 三郎');
        $response->assertSee('購入検討中');
        $response->assertSee('山田 四郎');
        $response->assertSee('どうしても買いたい。');
        $response->assertSee('storage/images/IMG20231112_R.jpg');

        // ==============================
        // カテゴリ・状態見出し確認
        // ==============================
        $response->assertSee('カテゴリー');
        $response->assertSee('商品の状態');

        // ==============================
        // 購入ボタン関連の確認
        // ==============================
        $response->assertSee('購入手続きへ');

        // SOLD状態でない商品なのでボタンが有効であること（disabledでない）
        $html = $response->getContent();
        $this->assertStringNotContainsString('disabled', $html);

        // ==============================
        // 構造確認（タイトル系）
        // ==============================
        $response->assertSee('商品説明');
        $response->assertSee('商品の情報');
    }
}
