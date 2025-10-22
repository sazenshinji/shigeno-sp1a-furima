<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Mockery;
use Stripe\Checkout\Session as StripeSession;

class PurchaseTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_商品購入機能()
    {
        // ログイン（user_id=3）
        $user = User::find(3);
        $this->actingAs($user);

        // 対象商品（革靴：product_id=4）
        $product = Product::find(4);

        // ----------------------------------------------------
        // 購入画面が表示される
        // ----------------------------------------------------
        $response = $this->get(route('products.purchase', $product->id));
        $response->assertStatus(200);
        $response->assertSeeText('支払い方法');
        $response->assertSeeText('購入する');

        // ----------------------------------------------------
        // Stripeセッション生成をモック
        // ----------------------------------------------------
        $mockSession = Mockery::mock('alias:' . StripeSession::class);
        $mockSession->shouldReceive('create')
            ->once()
            ->andReturn((object)[
                'url' => 'https://checkout.stripe.com/test-session'
            ]);

        // ----------------------------------------------------
        // コンビニ払い」で購入処理
        // ----------------------------------------------------
        $postResponse = $this->post(route('products.checkout', $product->id), [
            'payment_method' => 1, // コンビニ払い
            'postal_code' => '123-0001',
            'address' => '東京都港区高輪3-3-3',
            'building' => 'ABCマンション303',
        ]);

        // StripeのリダイレクトURLに遷移することを確認
        $postResponse->assertRedirect('https://checkout.stripe.com/test-session');

        // ----------------------------------------------------
        // Transactionsテーブルに登録されたことを確認
        // ----------------------------------------------------
        $this->assertDatabaseHas('transactions', [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'payment_method' => 1,
        ]);

        // ----------------------------------------------------
        // indexページでSOLD表示を確認
        // ----------------------------------------------------
        $indexResponse = $this->get(route('products.index'));
        $indexResponse->assertStatus(200);

        // 「革靴」画像と「SOLD」オーバーレイが両方含まれる
        $indexResponse->assertSeeText('革靴');
        $indexResponse->assertSee('storage/images/11_sold2.png');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
