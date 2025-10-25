<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Mockery;
use Stripe\Checkout\Session as StripeSession;

class L_DeliveryAddressChangeTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_配送先変更機能()
    {
        // ----------------------------------------------------
        // ① ログイン (user_id=3)
        // ----------------------------------------------------
        $user = \App\Models\User::find(3);
        $this->actingAs($user);

        // 商品（革靴：product_id=4）
        $product = \App\Models\Product::find(4);

        // ----------------------------------------------------
        // ② 購入画面にアクセスできることを確認
        // ----------------------------------------------------
        $response = $this->get(route('products.purchase', $product->id));
        $response->assertStatus(200);
        $response->assertSee('配送先');
        $response->assertSee('変更する');

        // ----------------------------------------------------
        // ③ 「変更する」リンクで edit_temp に遷移できることを確認
        // ----------------------------------------------------
        $editUrl = route('profile.edit_temp', ['product_id' => $product->id]);
        $this->get($editUrl)->assertStatus(200)
            ->assertSee('住所の変更')
            ->assertSee('郵便番号')
            ->assertSee('更新する');

        // ----------------------------------------------------
        // ④ edit_temp画面で住所変更を送信 → purchase画面に戻る
        // ----------------------------------------------------
        $updateData = [
            'product_id' => $product->id,
            'postal_code' => '567-8901',
            'address' => '東京都港区テスト1-1-1',
            'building' => 'PHPUnit101',
        ];

        // update-tempへPOST → purchase画面へリダイレクト
        $updateResponse = $this->post(route('profile.update_temp'), $updateData);
        $updateResponse->assertRedirect(route('products.purchase', ['product' => $product->id]));

        // リダイレクト後のpurchase画面を取得
        $purchaseResponse = $this->get(route('products.purchase', $product->id));

        // 住所が反映されていることを確認
        $purchaseResponse->assertSee('567-8901');
        $purchaseResponse->assertSee('東京都港区テスト1-1-1');
        $purchaseResponse->assertSee('PHPUnit101');

        // ----------------------------------------------------
        // ⑤ Stripeモック設定
        // ----------------------------------------------------
        $mockSession = Mockery::mock('alias:' . StripeSession::class);
        $mockSession->shouldReceive('create')
            ->once()
            ->andReturn((object)['url' => 'https://checkout.stripe.com/test-session']);

        // ----------------------------------------------------
        // ⑥ コンビニ払いで購入処理（JSONレスポンス対応）
        // ----------------------------------------------------
        $purchasePost = $this->postJson(route('products.checkout', $product->id), [
            'payment_method' => 1,
            'postal_code' => '567-8901',
            'address' => '東京都港区テスト1-1-1',
            'building' => 'PHPUnit101',
        ]);

        $purchasePost->assertStatus(200)
            ->assertJson([
                'url' => 'https://checkout.stripe.com/test-session',
            ]);

        // ----------------------------------------------------
        // ⑦ Transactionsテーブルに住所情報が正しく保存されている
        // ----------------------------------------------------
        $this->assertDatabaseHas('transactions', [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'payment_method' => 1,
            'postal_code' => '567-8901',
            'address' => '東京都港区テスト1-1-1',
            'building' => 'PHPUnit101',
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
