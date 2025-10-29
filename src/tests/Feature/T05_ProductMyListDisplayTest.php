<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class T05_ProductMyListDisplayTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_マイリスト一覧取得_商品表示_SOLD表示()
    {
        // --- ログインユーザーをシーディングデータから取得 ---
        $user = User::where('email', '1234@abcd2')->first();
        $this->actingAs($user);

        // --- マイリストタブにアクセス ---
        $response = $this->get(route('products.index', ['tab' => 'mylist']));

        // --- 検証 ---
        // user_id=2 がいいねしている商品
        $response->assertSee('腕時計');
        $response->assertSee('ノートPC');

        // いいねしていない商品
        $response->assertDontSee('HDD');
        $response->assertDontSee('マイク');
        $response->assertDontSee('ショルダーバッグ');

        // --- SOLD画像の表示検証 ---
        $html = $response->getContent();

        // 「ノートPC」はtransactionsに存在する → SOLD画像あり
        $this->assertMatchesRegularExpression(
            '/ノートPC.*sold-overlay/s',
            $html,
            'ノートPCにSOLD画像が表示されていません。'
        );

        // SOLD画像パスの存在確認
        $response->assertSee('images/11_sold2.png', false);
    }

    public function test_マイリスト一覧取得_ログアウト時はメッセージが表示され商品が非表示()
    {
        // --- ログアウト状態でアクセス（actingAsなし） ---
        $response = $this->get(route('products.index', ['tab' => 'mylist']));

        // --- ステータス確認 ---
        $response->assertStatus(200);
        $response->assertViewIs('products.index');

        $html = $response->getContent();

        // 「マイリスト」タブが通常リンクで存在している
        $this->assertStringContainsString(
            '<a href="',
            $html,
            'ログアウト時もマイリストタブがリンクとして存在している必要があります。'
        );

        $this->assertStringContainsString(
            'マイリスト',
            $html,
            'マイリストタブのテキストが表示されていません。'
        );

        // メッセージ「マイリストの表示にはログインが必要です。」が表示される
        $response->assertSee('マイリストの表示にはログインが必要です。');

        // 商品カードが表示されていない（product-cardクラスが含まれない）
        $this->assertStringNotContainsString(
            'product-card',
            $html,
            'ログアウト時に商品カードが表示されています。'
        );
    }
}
