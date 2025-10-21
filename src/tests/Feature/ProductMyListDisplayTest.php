<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProductMyListDisplayTest extends TestCase
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

        // SOLD画像パスの存在確認（HTMLに含まれているか）
        $response->assertSee('images/11_sold2.png', false);
    }

    public function test_マイリスト一覧取得_ログアウトは何も表示されない()
    {
        // --- ログアウト状態でアクセス（actingAsなし） ---
        $response = $this->get(route('products.index', ['tab' => 'mylist']));

        // --- ステータス確認 ---
        $response->assertStatus(200);
        $response->assertViewIs('products.index');

        $html = $response->getContent();

        // マイリストタブが無効（disabled）である
        $this->assertStringContainsString(
            '<span class="tab disabled">マイリスト</span>',
            $html,
            'ログアウト時のマイリストタブが無効化されていません。'
        );

        // 「おすすめ」タブの商品が表示されている（product-cardが存在する）
        $this->assertStringContainsString(
            'product-card',
            $html,
            'ログアウト時におすすめ商品が表示されていません。'
        );

    }

}