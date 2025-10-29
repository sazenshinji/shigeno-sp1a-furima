<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class T13_UserInformationTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_ユーザー情報取得()
    {
        // ----------------------------------------------------
        // user_id=1 でログイン
        // ----------------------------------------------------
        $user = User::find(1);
        $this->actingAs($user);

        // ----------------------------------------------------
        // index画面でマイページリンクをクリック → /profile に遷移
        // ----------------------------------------------------
        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
        $response->assertSee('マイページ');

        // ----------------------------------------------------
        // /profile?tab=sell （出品した商品タブ）
        // ----------------------------------------------------
        $sellResponse = $this->get(route('profile.show', ['tab' => 'sell']));
        $sellResponse->assertStatus(200);

        // 出品タブでは「腕時計」「HDD」が表示される（seller_id=1）
        $sellResponse->assertSee('腕時計');
        $sellResponse->assertSee('HDD');

        // 購入タブの商品「ショルダーバッグ」は表示されない
        $sellResponse->assertDontSee('ショルダーバッグ');

        // ----------------------------------------------------
        // /profile?tab=buy （購入した商品タブ）
        // ----------------------------------------------------
        $buyResponse = $this->get(route('profile.show', ['tab' => 'buy']));
        $buyResponse->assertStatus(200);

        // 購入タブでは「ショルダーバッグ」が表示される（transactionsにuser_id=1）
        $buyResponse->assertSee('ショルダーバッグ');

        // 出品商品の「腕時計」「HDD」は非表示
        $buyResponse->assertDontSee('腕時計');
        $buyResponse->assertDontSee('HDD');

        // ----------------------------------------------------
        // ユーザー情報確認（共通要素）
        // ----------------------------------------------------
        $buyResponse->assertSee('images/IMG20231112_R.jpg'); // プロフ画像
        $buyResponse->assertSee('山田 太郎');               // ユーザー名
    }
}
