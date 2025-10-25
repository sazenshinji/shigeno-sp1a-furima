<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class G_ProductShowTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_商品詳細情報取得()
    {
        // 🔹 対象の商品（革靴 = product_id=4）詳細ページにアクセス
        $response = $this->get(route('products.show', 4));

        // 🔹 ステータス200（正常表示）
        $response->assertStatus(200);

        // ==============================
        // 🔽 表示確認セクション
        // ==============================

        // 商品名
        $response->assertSee('革靴');

        // ブランド
        $response->assertSee('X靴製作所');

        // 価格（税込）
        $response->assertSee('4,000');
        $response->assertSee('(税込)');

        // 商品画像
        $response->assertSee('storage/images/04_革靴.jpg');

        // いいね数（この商品は likes テーブルに登録なし → 0）
        $response->assertSee('0');

        // コメント数（この商品は comments 2件）
        $response->assertSee('コメント(2)');

        // 商品説明
        $response->assertSee('クラシックなデザインの革靴');

        // カテゴリ（ファッション / メンズ）
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');

        // 商品状態（condition_id=4 → 状態が悪い）
        $response->assertSee('状態が悪い');

        // ==============================
        // 🔽 コメント表示の確認
        // ==============================

        // コメント1（user_id=3 → 山田 三郎）
        $response->assertSee('山田 三郎');
        $response->assertSee('購入検討中');
        // コメント2（user_id=4 → 山田 四郎）
        $response->assertSee('山田 四郎');
        $response->assertSee('どうしても買いたい。');

        // コメントユーザー画像（profiles.user_image）
        $response->assertSee('storage/images/IMG20231112_R.jpg');

        // ==============================
        // 🔽 構造的な要素確認
        // ==============================
        $response->assertSee('商品説明');
        $response->assertSee('商品の情報');
    }
}
