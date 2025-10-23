<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;

class MUserInformationTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_ユーザー情報取得()
    {
        // ----------------------------------------------------
        // ① user_id=1 でログイン
        // ----------------------------------------------------
        $user = User::find(1);
        $this->actingAs($user);

        // ----------------------------------------------------
        // ② index画面でマイページリンクをクリック → /profile に遷移
        // ----------------------------------------------------
        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
        $response->assertSee('マイページ');

        // マイページにアクセス
        $profileResponse = $this->get(route('profile.show'));
        $profileResponse->assertStatus(200);

        // ----------------------------------------------------
        // ③ ユーザー画像・ユーザー名が正しく表示されている
        // ----------------------------------------------------
        $profileResponse->assertSee('images/IMG20231112_R.jpg'); // プロフ画像
        $profileResponse->assertSee('山田 太郎');               // ユーザー名

        // ----------------------------------------------------
        // ④ 出品した商品タブの内容を確認
        //     user_id=1 が seller_id の商品は「腕時計」「HDD」
        // ----------------------------------------------------
        $profileResponse->assertSee('腕時計');
        $profileResponse->assertSee('HDD');

        // ----------------------------------------------------
        // ⑤ 購入した商品タブの内容を確認
        //     user_id=1 が transactions に存在 → product_id=7「ショルダーバッグ」
        // ----------------------------------------------------
        $profileResponse->assertSee('ショルダーバッグ');

        // ----------------------------------------------------
        // ⑥ 不要な商品が表示されていないことを簡易チェック（任意）
        // ----------------------------------------------------
        $profileResponse->assertDontSee('ノートPC');
        $profileResponse->assertDontSee('マイク');
    }
}
